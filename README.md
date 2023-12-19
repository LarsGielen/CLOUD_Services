# MusicHub
***Discover, book, and share musical experiences with our various services.***

Authentication met laravel beeze

## Deelservices
### 1. GraphQL:
- **Servicenaam:** InstrumentLibraryAPI
- **Programmeertaal:** JavaScript / Node.js
- **Programmeertaal uit de les:** Python

**Beschrijving:** 

Een GraphQL-service voor het kopen en verkopen van instrumenten. Muzikanten kunnen hun niet gebruikte instrumenten verkopen aan mensen die graag een 2de hands instrument willen kopen. Je kan instrumenten zoeken op onder andere het type, leeftijd, locatie en prijs. De GraphQL-service biedt een flexibele en efficiënte manier voor gebruikers om specifieke gegevens op te vragen, waardoor overbodige gegevens worden vermeden.

### 2. REST (Representational State Transfer):
- **Servicenaam:** EventBookingAPI
- **Programmeertaal:** PHP / Laravel Framework
- **Programmeertaal uit de les:** PHP / Laravel Framework

**Beschrijving:** 

Een REST API voor het boeken van klassieke muziekevenementen. Muzikanten en evenementorganisatoren kunnen de API gebruiken om locaties voor muziekoptredens te beheren en te boeken. De API stelt gebruikers in staat om te zoeken naar komende evenementen, tickets te boeken en informatie te verkrijgen over de uitvoerders en het programma.

### 3. gRPC (Remote Procedure Call):
- **Servicenaam:** MusicTunerService
- **Programmeertaal:** C#
- **Programmeertaal uit de les:** java

**Beschrijving:** 

Een gRPC-service voor het stemmen van muziekinstrumenten. Muzikanten kunnen verbinding maken met de Tuner-service, het stemproces starten, continue updates over de stemstatus ontvangen en zo nodig aanpassingen maken.

### 4. SOAP (Simple Object Access Protocol):
- **Servicenaam:** SheetMusicRepository
- **Programmeertaal:** Java
- **Programmeertaal uit de les:** C#

**Beschrijving:** 

Een SOAP service waarmee klassieke muzikanten toegang hebben tot een repository van digitale bladmuziek. Muzikanten kunnen zoeken naar specifieke composities, bladmuziek ophalen in verschillende formaten en zelfs hun eigen composities uploaden om te delen met anderen.

### 5. MQTT (Message Queuing Telemetry Transport):
- **Servicenaam:** RealTimeMusicUpdates
- **Programmeertaal:** Python
- **Programmeertaal uit de les:** Python

**Beschrijving:** 

Een op MQTT gebaseerde service voor het verzenden van realtime updates over nieuwe bladmuziek en/of populaire bladmuziek. Geabonneerde gebruikers ontvangen direct meldingen bij veranderingen of nieuwe inhoud.

### 6. Websockets:
- **Servicenaam:** CollaborativeMusicSession
- **Programmeertaal:** JavaScript / Node.js
- **Programmeertaal uit de les:** JavaScript / Node.js

**Beschrijving:** 

Een WebSocket-service voor het hosten van gezamenlijke muziek sessies. Muzikanten kunnen verbinding maken met de service, deelnemen aan een virtuele kamer waar ze met elkaar kunnen chatten en samen bladmuziek kunnen maken.

## Consumatie van services
De verschillende services zullen worden geconcumeerd in laravel met php. Ook zal de publieke API van openopus (https://github.com/openopus-org/openopus_api/tree/master) worden gebruikt om een database de hebben van verschillende componisten en hun composities.
