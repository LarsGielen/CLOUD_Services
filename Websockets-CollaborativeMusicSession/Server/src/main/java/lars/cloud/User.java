package lars.cloud;

import org.springframework.web.socket.WebSocketSession;

public class User {
    private final WebSocketSession session;
    private String roomName;

    public User(WebSocketSession session) {
        this.session = session;
        this.roomName = "";
    }
    
    public WebSocketSession getSession() {
        return session;
    }

    public String getRoomName() {
        return roomName;
    }

    public void setRoomName(String roomName) {
        this.roomName = roomName;
    }
}
