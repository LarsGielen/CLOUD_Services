<?php

require_once "database.php";
require_once "pdfConverter.php";

class SoapService {
    /**
     * This function stores the given music in the server and returns the newly created SheetMusic object
     *
     * @param string $abcNotation
     * @param int $userID
     * @param string $musicTitle
     * @return string inserted music object as a json string
     */
    function storeMusic($abcNotation, $userID, $musicTitle)
    {
        $id = (new DatabaseHandler())->insertSheetMusic( new SheetMusic(
            abcNotation: $abcNotation,
            userID: $userID,
            musicTitle: $musicTitle,
        ));
        
        return json_encode([ 'data' => SheetMusic::sheetMusicListToJson((new DatabaseHandler())->getSheetMusicById($id))]);
    }

    /**
     * This function returs all the music stored in this api
     *
     * @return string music object as a json string
     */
    function getMusic()
    {
        return json_encode([ 'data' => SheetMusic::sheetMusicListToJson((new DatabaseHandler())->getAllSheetMusic())]);
    }

    /**
     * This function returns the music for the given ID.
     *
     * @param int $id
     * @return string music object as a json encoded string
     */
    function getMusicByID($id)
    {
        return json_encode(['data' => SheetMusic::sheetMusicListToJson((new DatabaseHandler())->getSheetMusicById($id))]);
    }

    /**
     * This function returns all music for the given user ID.
     *
     * @param int $userID
     * @return string list of music objects as a json encoded string
     */
    function getMusicByUserID($userID)
    {
        return json_encode(['data' => SheetMusic::sheetMusicListToJson((new DatabaseHandler())->getSheetMusicByUserID($userID))]);
    }

    /**
     * This function returns all the music with the given title.
     *
     * @param string $musicTitle
     * @return string music object as a json encoded string
     */
    function getMusicByTitle($musicTitle)
    {
        return json_encode(['data' => SheetMusic::sheetMusicListToJson((new DatabaseHandler())->getSheetMusicByTitle($musicTitle))]);
    }

    /**
     * This function returns all the music with a title that contains the given title.
     * @param string $musicTitle
     * @return string music object as a json encoded string
     */
    function getMusicLikeTitle($musicTitle)
    {
        return json_encode(['data' => SheetMusic::sheetMusicListToJson((new DatabaseHandler())->getSheetMusicByTitleLike($musicTitle))]);
    }

    /**
     * 
     * This function generates a PDF from the music with the given ID. 
     * If it has already created it it wil just return the url of the pdf without generating it again. 
     * After receiving the url you can view the pdf at:
     * http://localhost:5050/pdfs/name_of.pdf
     *
     * @param int $id
     * @return string url to the pdf
     */
    function convertMusicToPdfById($id)
    {
        $sheetMusic = (new DatabaseHandler())->getSheetMusicById($id)[0];

        $url = $sheetMusic->getPdfUrl();
        if ($url == null) {
            $url = (new AbcToPDFConverter())->convert($sheetMusic);

            if ($url == null) {
                return json_encode([ 'data' => "failed to create pdf"]);
            }

            (new DatabaseHandler())->updateSheetMusic(new SheetMusic(
                abcNotation: $sheetMusic->getAbcNotation(),
                userID: $sheetMusic->getUserID(),
                musicTitle: $sheetMusic->getMusicTitle(),
                id: $sheetMusic->getId(),
                pdfUrl: $url,
            ));
        }

        return json_encode( ['data' => $url ]);
    }
}

?>