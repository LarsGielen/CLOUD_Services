const fs = require('fs');
const csv = require('csv-parser');

function loadData(fileName, onData) {
    fs.createReadStream('./src/Data/' + fileName + '.csv').pipe(csv())
    .on('data', (row) => {
        onData(row);
    })
    .on('end', () => {
        console.log(fileName + ' CSV file successfully loaded');
    })
    .on('error', (error) => {
        console.error(fileName + ' CSV file gave an error: ' + error);
    });
}

function loadInstruments() {
    const Instruments = [];
    loadData("Instruments", (row) => {
        Instruments.push({
            name: row.name,
            type: row.type,
            description: row.description,
            age: parseFloat(row.age),
            condition: row.condition,
            price: parseFloat(row.price),
            location: row.location,
            sellerUserName: row.seller
        });
    })
    
    return Instruments;
}

function loadInstrumentTypes() {
    const InstrumentTypes = [];
    loadData("InstrumentTypes", (row) => {
        InstrumentTypes.push({
            name: row.name,
            family: row.family
        });
    })
    
    return InstrumentTypes;
}

function loadUsers() {
    const Users = [];
    loadData("Users", (row) => {
        Users.push({
            id: row.id,
            userName: row.userName,
            email: row.email,
            location: row.location
        });
    })
    
    return Users;
}

module.exports = {
    loadInstruments,
    loadInstrumentTypes,
    loadUsers
};