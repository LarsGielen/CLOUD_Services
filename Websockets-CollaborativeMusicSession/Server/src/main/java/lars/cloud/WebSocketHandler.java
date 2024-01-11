package lars.cloud;

import java.io.IOException;
import java.util.concurrent.ConcurrentHashMap;

import org.springframework.web.socket.CloseStatus;
import org.springframework.web.socket.TextMessage;
import org.springframework.web.socket.WebSocketSession;
import org.springframework.web.socket.handler.TextWebSocketHandler;

import com.google.gson.Gson;

public class WebSocketHandler extends TextWebSocketHandler {
    private static final ConcurrentHashMap<String, MusicSessionRoom> rooms = new ConcurrentHashMap<>();
    private static final ConcurrentHashMap<WebSocketSession, User> users = new ConcurrentHashMap<>();

    @Override
    public void afterConnectionEstablished(WebSocketSession session) throws Exception 
    {
        users.put(session, new User(session));
    }

    @Override
    public void afterConnectionClosed(WebSocketSession session, CloseStatus status) throws Exception 
    {
        User user = users.get(session);

        leaveRoom(user);
        users.remove(session);
    }

    @Override
    protected void handleTextMessage(WebSocketSession session, TextMessage message) throws Exception 
    {
        Gson gson = new Gson();
        MusicSessionData data = gson.fromJson(message.getPayload(), MusicSessionData.class);

        User user = users.get(session);

        switch (data.status) {
            case JOIN:
                joinRoom(user, data);
                break;
            case LEAVE:
                leaveRoom(user);
                break;
            case UPDATE:
                updateRoom(user, data);
                break;
        }
    }

    private void joinRoom(User user, MusicSessionData data) throws IOException 
    {
        if (data.roomName.isEmpty()) {
            user.getSession().close();
            return;
        }

        if (user.getRoomName() == data.roomName) {
            user.getSession().close();
            return;
        }

        if (!rooms.containsKey(data.roomName)) {
            // if room does not exists -> create room
            MusicSessionRoom room = new MusicSessionRoom(data.roomName);
            rooms.put(data.roomName, room);
        }

        if (!rooms.get(data.roomName).hasUser(user)) {
            // join room
            rooms.get(data.roomName).addUser(user);
            user.setRoomName(data.roomName);
        }
    }

    private void leaveRoom(User user) throws IOException
    {
        String roomName = user.getRoomName();
        MusicSessionRoom room = rooms.get(roomName);

        user.setRoomName("");
        if (room == null) return;
        
        room.removeUser(user);
        if (room.getUsermount() == 0) {
            System.out.println("Removed room: " + room.getRoomName());
            rooms.remove(room.getRoomName());
        }
    }

    private void updateRoom(User user, MusicSessionData data) throws IOException 
    {
        MusicSessionRoom room = rooms.get(user.getRoomName());
        room.setSharedText(data.sharedText);
    }
}

