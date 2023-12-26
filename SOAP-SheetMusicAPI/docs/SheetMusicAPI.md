# Introduction

The SheetMusicAPI is a SOAP-based API for storing, finding and converting sheet music. The server is developed with the Laminas soap framework for php. The data is stored in a mysql database in 'ABC' music notation, an easy to understand musical notation that uses letters to represent the corresponding notes. This API is also capable of converting its stored music into a pdf. For this the [puphpeteer](https://github.com/rialto-php/puphpeteer) package (php wrapper for [puppeteer](https://github.com/puppeteer/puppeteer)) is used.

# Running the API server

Before running the API, make sure to install the required dependencies. The following command installs the necessary packages:

```console
composer require laminas/laminas-soap 
composer require nesk/puphpeteer
npm install @nesk/puphpeteer
```

Run a mysql database instance and make sure the settings in the database.php file are correct. The standard values work if the database is running on your localhost using xampp.

```
host = 'localhost';
rootUser = 'root';
rootPass = '';
```

To start the server, run the following command in a terminal window:

```console
php -S localhost:5050 -t C:\path\to\project
```

The port (5050) can be changed to any available port, but remember to change the port in the SheetMusicAPI.php file as well.

# USing the api

## API Endpoints

The API is accesed by making a post request to the following: \
`http://localhost:5050/SheetMusicAPI.php` 

The response contains a json encoded string.

### storeMusic

This function stores the given music on the server and returns the newly created SheetMusic object.

#### Request

```xml
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <storeMusic xmlns="http://localhost:5050/SheetMusicAPI.php">
            <abcNotation>[string]</abcNotation>
            <userID>[int]</userID>
            <musicTitle>[string]</musicTitle>
        </storeMusic>
    </Body>
</Envelope>
```
#### Reponse

```xml
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://localhost:5050/SheetMusicAPI.php" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
    <SOAP-ENV:Body>
        <ns1:storeMusicResponse>
            <return xsi:type="xsd:string">{"data":[{"id":1,"abcNotation":"...","userID":1,"musicTitle":"Title","pdfUrl":"..."}]}</return>
        </ns1:storeMusicResponse>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
```

### getMusic

This function returns all the music stored in the API.

#### Request

```xml
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <getMusic xmlns="http://localhost:5050/SheetMusicAPI.php"/>
    </Body>
</Envelope>
```
#### Reponse

```xml
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://localhost:5050/SheetMusicAPI.php" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
    <SOAP-ENV:Body>
        <ns1:getMusicResponse>
            <return xsi:type="xsd:string">{"data":[{"id":1,"abcNotation":"...","userID":1,"musicTitle":"Title","pdfUrl":"..."},{"id":2,"abcNotation":"...","userID":2,"musicTitle":"Title","pdfUrl":null}]}</return>
        </ns1:getMusicResponse>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
```

### getMusicByID

This function returns the music for the given ID.

#### Request

```xml
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <getMusicByID xmlns="http://localhost:5050/SheetMusicAPI.php">
            <id>[int]</id>
        </getMusicByID>
    </Body>
</Envelope>
```

#### Response

```xml
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://localhost:5050/SheetMusicAPI.php" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
    <SOAP-ENV:Body>
        <ns1:getMusicByIDResponse>
            <return xsi:type="xsd:string">{"data":[{"id":1,"abcNotation":"...","userID":1,"musicTitle":"Title","pdfUrl":"..."},{"id":2,"abcNotation":"...","userID":2,"musicTitle":"Title","pdfUrl":null}]}</return>
        </ns1:getMusicByIDResponse>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
```

### getMusicByUserID

This function returns all music for the given user ID.

#### Request

```xml
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <getMusicByUserID xmlns="http://localhost:5050/SheetMusicAPI.php">
            <userID>[int]</userID>
        </getMusicByUserID>
    </Body>
</Envelope>
```

#### Reponse

```xml
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://localhost:5050/SheetMusicAPI.php" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
    <SOAP-ENV:Body>
        <ns1:getMusicByUserIDResponse>
            <return xsi:type="xsd:string">{"data":[{"id":1,"abcNotation":"...","userID":1,"musicTitle":"Title","pdfUrl":"..."},{"id":2,"abcNotation":"...","userID":2,"musicTitle":"Title","pdfUrl":null}]}</return>
        </ns1:getMusicByUserIDResponse>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
```

### getMusicByTitle

This function returns all the music with the given title.

#### Request

```xml
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <getMusicByTitle xmlns="http://localhost:5050/SheetMusicAPI.php">
            <musicTitle>[string]</musicTitle>
        </getMusicByTitle>
    </Body>
</Envelope>
```

#### Response

```xml
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://localhost:5050/SheetMusicAPI.php" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
    <SOAP-ENV:Body>
        <ns1:getMusicByTitleResponse>
            <return xsi:type="xsd:string">{"data":[{"id":1,"abcNotation":"...","userID":1,"musicTitle":"Title","pdfUrl":"..."},{"id":2,"abcNotation":"...","userID":2,"musicTitle":"Title","pdfUrl":null}]}</return>
        </ns1:getMusicByTitleResponse>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
```

### getMusicLikeTitle

This function returns all the music with a title that contains the given title.

#### Request

```xml
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <getMusicLikeTitle xmlns="http://localhost:5050/SheetMusicAPI.php">
            <musicTitle>[string]</musicTitle>
        </getMusicLikeTitle>
    </Body>
</Envelope>
```

#### Response

```xml
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://localhost:5050/SheetMusicAPI.php" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
    <SOAP-ENV:Body>
        <ns1:getMusicLikeTitleResponse>
            <return xsi:type="xsd:string">{"data":[{"id":1,"abcNotation":"...","userID":1,"musicTitle":"Title","pdfUrl":"..."},{"id":2,"abcNotation":"...","userID":2,"musicTitle":"Title","pdfUrl":null}]}</return>
        </ns1:getMusicLikeTitleResponse>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
```

### convertMusicToPdfById

This function generates a PDF from the music with the given ID. If it has already created it it wil just return the url of the pdf without generating it again. After receiving the url you can view the pdf at: \ 
`http://localhost:5050/pdfs/name_of.pdf`


#### Request

```xml
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <convertMusicToPdfById xmlns="http://localhost:5050/SheetMusicAPI.php">
            <id>[int]</id>
        </convertMusicToPdfById>
    </Body>
</Envelope>
```

#### Reponse

```xml
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://localhost:5050/SheetMusicAPI.php" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
    <SOAP-ENV:Body>
        <ns1:convertMusicToPdfByIdResponse>
            <return xsi:type="xsd:string">{"data":"pdfs\/name_of.pdf"}</return>
        </ns1:convertMusicToPdfByIdResponse>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
```