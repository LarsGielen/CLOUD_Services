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

function loadInstrumentPosts() {
    const InstrumentPosts = [];
    loadData("InstrumentPosts", (row) => {
        InstrumentPosts.push({
            id: parseInt(row.id),
            title: row.title,
            description: row.description,
            type: row.type,
            age: parseFloat(row.age),
            condition: row.condition,
            price: parseFloat(row.price),
            location: row.location,
            sellerUserID: row.sellerUserID
        });
    })
    
    return InstrumentPosts;
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
            userID: row.userID,
            userName: row.userName,
            email: row.email,
        });
    })
    
    return Users;
}

module.exports = {
    loadInstrumentPosts,
    loadInstrumentTypes,
    loadUsers
};