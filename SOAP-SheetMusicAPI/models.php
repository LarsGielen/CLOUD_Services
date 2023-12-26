<?php

class SheetMusic {
    private $id;
    private $abcNotation;
    private $userID;
    private $musicTitle;
    private $pdfUrl;

    /**
     * @param int $id
     * @param string $abcNotation
     * @param int $userID
     * @param string $musicTitle
     * @param string $pdfUrl
     */
    public function __construct($abcNotation, $userID, $musicTitle, $id = -1, $pdfUrl = null) {
        $this->id = $id;
        $this->abcNotation = $abcNotation;
        $this->userID = $userID;
        $this->musicTitle = $musicTitle;
        $this->pdfUrl = $pdfUrl;
    }

    public function getId() {
        return $this->id;
    }

    public function getAbcNotation() {
        return $this->abcNotation;
    }

    public function setAbcNotation($abcNotation) {
        $this->abcNotation = $abcNotation;
    }

    public function getUserID() {
        return $this->userID;
    }

    public function setUserID($userID) {
        $this->userID = $userID;
    }

    public function getMusicTitle() {
        return $this->musicTitle;
    }

    public function setMusicTitle($musicTitle) {
        $this->musicTitle = $musicTitle;
    }

    /**
     * @return string|null
     */
    public function getPdfUrl() {
        return $this->pdfUrl;
    }

    public function setPdfUrl($url) {
        $this->pdfUrl = $url;
    }

    public function __toString() {
        return json_encode([
            'id' => $this->id,
            'abcNotation' => $this->abcNotation,
            'userID' => $this->userID,
            'musicTitle' => $this->musicTitle,
            'pdfUrl' => $this->pdfUrl,
        ]);
    }

    public static function sheetMusicList($sheetMusicList) {
        $jsonArray = [];

        foreach ($sheetMusicList as $sheetMusic) {
            $jsonArray[] = [
                'id' => $sheetMusic->getId(),
                'abcNotation' => $sheetMusic->getAbcNotation(),
                'userID' => $sheetMusic->getUserID(),
                'musicTitle' => $sheetMusic->getMusicTitle(),
                'pdfUrl' => $sheetMusic->getPdfUrl(),
            ];
        }

        return $jsonArray;
    }
}


?>