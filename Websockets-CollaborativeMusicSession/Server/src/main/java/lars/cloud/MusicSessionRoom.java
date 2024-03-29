package lars.cloud;

import java.io.IOException;
import java.util.List;
import java.util.concurrent.CopyOnWriteArrayList;

import org.springframework.web.socket.TextMessage;

import com.google.gson.Gson;

import lars.cloud.MusicSessionData.Status;

public class MusicSessionRoom {
    private final List<User> users = new CopyOnWriteArrayList<>();
    private final StringBuffer sharedText = new StringBuffer();

    private final String roomName;
    private int userAmount;

    public MusicSessionRoom(String roomName) {
        this.roomName = roomName;
        userAmount = 0;
        System.out.println("New Room created: " + roomName);
        sharedText.append(
            "X: 1\n" + //
            "M: 4/4\n" + //
            "L: 1/8\n" + //
            "R: reel\n" + //
            "K: Emin\n" + //
            "|:D2|EB{c}BA B2 EB|~B2 AB dBAG|FDAD BDAD|FDAD dAFD|\n" + //
            "EBBA B2 EB|B2 AB defg|afe^c dBAF|DEFD E2:|\r\n" + //
            "|:gf|eB B2 efge|eB B2 gedB|A2 FA DAFA|A2 FA defg|\n" + //
            "eB B2 eBgB|eB B2 defg|afe^c dBAF|DEFD E2:|\n"
        );
    }

    public void addUser(User user) throws IOException {
        users.add(user);
        userAmount++;

        user.getSession().sendMessage(new TextMessage(getJson()));
        System.out.println("Session joined room: " + roomName);
    }

    public void removeUser(User user) {
        users.remove(user);
        userAmount--;

        System.out.println("Session left room: " + roomName);
    }

    public void setSharedText(String text) throws IOException {
        sharedText.setLength(0);
        sharedText.append(text);

        // send the message to all sessions in this room
        for(User user : users) {
            user.getSession().sendMessage(new TextMessage(getJson()));
        }
    }

    public String getSharedText() {
        return sharedText.toString();
    }

    public String getRoomName() {
        return roomName;
    }

    public int getUsermount() {
        return userAmount;
    }

    public Boolean hasUser(User user) {
        return users.contains(user);
    }

    public String getJson() {
        return (new Gson()).toJson(new MusicSessionData(getRoomName(), getSharedText(), Status.UPDATE));
    }
}
