package lars.cloud;

public class MusicSessionData {
    public enum Status { JOIN, UPDATE, LEAVE };

    public String roomName;
    public String sharedText;
    public Status status;

    public MusicSessionData(String roomName, String sharedText, Status status) {
        this.roomName = roomName;
        this.sharedText = sharedText;
        this.status = status;
    }
}
