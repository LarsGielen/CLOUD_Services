<?php

require_once 'models.php';

class DatabaseHandler {
    private $host;
    private $rootUser;
    private $rootPass;

    private $databaseName;
    private $sheetMusicTable;
    private $db;

    public function __construct() {
        $this->host = getenv('DB_HOST') ?: 'localhost';
        $this->rootUser = 'root';
        $this->rootPass = getenv('DB_ROOT_PASSWORD') ?: '';

        $this->databaseName = 'SheetMusicDatabase';
        $this->sheetMusicTable = 'SheetMusicTable';

        try {
            $this->db = new PDO("mysql:host={$this->host}", $this->rootUser, $this->rootPass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if the database already exists
            $stmt = $this->db->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :databaseName");
            $stmt->bindParam(':databaseName', $this->databaseName);
            $stmt->execute();

            if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
                // Create the database if it doesn't exist
                $this->db->exec("CREATE DATABASE {$this->databaseName}");
                error_log("Database created successfully: {$this->databaseName}");

                // go inside database
                $this->db->exec("USE {$this->databaseName}");

                // create table
                $this->db->exec("CREATE TABLE {$this->sheetMusicTable} ( id int PRIMARY KEY AUTO_INCREMENT, abcNotation TEXT, userID int, musicTitle VARCHAR(255), pdfUrl TEXT)");
                error_log("Table created successfully: {$this->sheetMusicTable}");

                $databaseHandler = new DatabaseHandler();

                // Insert data
                $databaseHandler->insertSheetMusic(new SheetMusic(
                    abcNotation: "X:1\nM: 4/4\nL: 1/8\nR: reel\nK: Emin\n|:D2|EB{c}BA B2 EB|~B2 AB dBAG|FDAD BDAD|FDAD dAFD|\nEBBA B2 EB|B2 AB defg|afe^c dBAF|DEFD E2:|\n|:gf|eB B2 efge|eB B2 gedB|A2 FA DAFA|A2 FA defg|\neB B2 eBgB|eB B2 defg|afe^c dBAF|DEFD E2:|",
                    userID: 1,
                    musicTitle: "Example Music 1",
                ));

                $databaseHandler->insertSheetMusic(new SheetMusic(
                    abcNotation: "X:1\nK:D\nDD AA|BBA2|\n",
                    userID: 1,
                    musicTitle: "Example Music 2",
                ));
            } 
            else {
                // go inside database
                $this->db->exec("USE {$this->databaseName}");
            }
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * @param SheetMusic $data
     * @return int id of inserted SheetMusic object
     */
    public function insertSheetMusic($sheetMusic) {
        try {

            $data = [
                'abcNotation' => $sheetMusic->getAbcNotation(),
                'userID' => $sheetMusic->getUserID(),
                'musicTitle' => $sheetMusic->getMusicTitle(),
                'pdfUrl' => $sheetMusic->getPdfUrl(),
            ];

            // Insert data into the table
            $stmt = $this->db->prepare("INSERT INTO {$this->sheetMusicTable} (abcNotation, userID, musicTitle, pdfUrl) VALUES (:abcNotation, :userID, :musicTitle, :pdfUrl)");
            $stmt->bindParam(':abcNotation', $data['abcNotation']);
            $stmt->bindParam(':userID', $data['userID']);
            $stmt->bindParam(':musicTitle', $data['musicTitle']);
            $stmt->bindParam(':pdfUrl', $data['pdfUrl']);
            $stmt->execute();

            error_log("Inserted SheetMusic object successfully into {$this->sheetMusicTable}: {$data['musicTitle']}");
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * @param SheetMusic $sheetMusic
     */
    public function updateSheetMusic($sheetMusic) {
        try {
            $data = [
                'abcNotation' => $sheetMusic->getAbcNotation(),
                'userID' => $sheetMusic->getUserID(),
                'musicTitle' => $sheetMusic->getMusicTitle(),
                'id' => $sheetMusic->getId(),
                'pdfUrl' => $sheetMusic->getPdfUrl(),
            ];

            $stmt = $this->db->prepare("UPDATE {$this->sheetMusicTable} SET abcNotation = :abcNotation, userID = :userID, musicTitle = :musicTitle, pdfUrl = :pdfUrl WHERE id = :id");
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':abcNotation',$data['abcNotation']);
            $stmt->bindParam(':userID', $data['userID']);
            $stmt->bindParam(':musicTitle', $data['musicTitle']);
            $stmt->bindParam(':pdfUrl', $data['pdfUrl']);
            $stmt->execute();

            return "SheetMusic updated successfully";
        } catch (PDOException $e) {
            // Handle or log the exception as needed
            throw $e;
        }
    }

    /**
     * Get all sheet music records from the database
     *
     * @return SheetMusic[] list of all SheetMusic objects
     */
    public function getAllSheetMusic()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM {$this->sheetMusicTable}");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->execute();

            $sheetMusicList = [];

            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $sheetMusic = new SheetMusic(
                    $result['abcNotation'],
                    $result['userID'],
                    $result['musicTitle'],
                    $result['id'],
                    $result['pdfUrl']
                );

                $sheetMusicList[] = $sheetMusic;
            }

            return $sheetMusicList;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param int $sheetMusicId
     * @return SheetMusic[] list of music objects as a json encoded string
     */
    public function getSheetMusicById($sheetMusicId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->sheetMusicTable} WHERE id = :sheetMusicId");
            $stmt->bindParam(':sheetMusicId', $sheetMusicId);
            $stmt->execute();

            $sheetMusicList = [];

            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $sheetMusic = new SheetMusic(
                    $result['abcNotation'],
                    $result['userID'],
                    $result['musicTitle'],
                    $result['id'],
                    $result['pdfUrl']
                );

                $sheetMusicList[] = $sheetMusic;
            }

            return $sheetMusicList;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param int $userID
     * @return SheetMusic[] list of music objects as a json encoded string
     */
    public function getSheetMusicByUserID($userID) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->sheetMusicTable} WHERE userID = :userID");
            $stmt->bindParam(':userID', $userID);
            $stmt->execute();

            $sheetMusicList = [];

            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $sheetMusic = new SheetMusic(
                    $result['abcNotation'],
                    $result['userID'],
                    $result['musicTitle'],
                    $result['id'],
                    $result['pdfUrl']
                );

                $sheetMusicList[] = $sheetMusic;
            }

            return $sheetMusicList;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }


    /**
     * @param string $title
     * @return SheetMusic[] list of music objects as a json encoded string
     */
    public function getSheetMusicByTitle($title) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->sheetMusicTable} WHERE musicTitle = :title");
            $stmt->bindParam(':title', $title);
            $stmt->execute();

            $sheetMusicList = [];

            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $sheetMusic = new SheetMusic(
                    $result['abcNotation'],
                    $result['userID'],
                    $result['musicTitle'],
                    $result['id'],
                    $result['pdfUrl']
                );

                $sheetMusicList[] = $sheetMusic;
            }

            return $sheetMusicList;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param string $title
     * @return SheetMusic[] list of music objects as a json encoded string
     */
    public function getSheetMusicByTitlelike($title) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->sheetMusicTable} WHERE musicTitle LIKE :title");
            $stmt->bindValue(':title', '%' . $title . '%', PDO::PARAM_STR);
            $stmt->execute();

            $sheetMusicList = [];

            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $sheetMusic = new SheetMusic(
                    $result['abcNotation'],
                    $result['userID'],
                    $result['musicTitle'],
                    $result['id'],
                    $result['pdfUrl']
                );

                $sheetMusicList[] = $sheetMusic;
            }

            return $sheetMusicList;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }
}
?>