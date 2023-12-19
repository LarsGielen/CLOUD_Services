const dataLoader = require('./DataLoader');

const Instruments = dataLoader.loadInstruments();
const InstrumentTypes = dataLoader.loadInstrumentTypes();
const Users = dataLoader.loadUsers();

// Query Resolvers
const queryResolver = {
    instruments: () => Instruments,
    instrumentTypes: () => InstrumentTypes,
    locations: getAllLocations,

    filterInstruments: filterInstruments,
    filterInstrumentTypes: filterInstrumentTypes,
}

function getAllLocations() {
    const locationSet = new Set();
    Users.forEach(user => locationSet.add(user.location));
    Instruments.forEach(instrument => locationSet.add(instrument.location));
    return [...locationSet].map(location => ({city: location}));
}

function filterInstruments(parent, args) {
    var filtered = Instruments;

    if (args.sellerUserName) {
        filtered = filtered.filter(instrument => instrument.sellerUserName == args.sellerUserName);
    }

    if (args.instrumentType) {
        filtered = filtered.filter(instrument => instrument.type == args.instrumentType);
    }

    if (args.instrumentFamily) {
        const instrumentTypeNames = filterInstrumentTypes(parent, args).map(type => type.name);
        filtered = filtered.filter(instrument => instrumentTypeNames.includes(instrument.type));
    }

    if (args.locationName) {
        filtered = filtered.filter(instrument => instrument.location == args.locationName);
    }

    if (args.condition) {
        filtered = filtered.filter(instrument => instrument.condition == args.condition);
    }

    if (args.priceMin) {
        filtered = filtered.filter(instrument => instrument.price >= args.priceMin);
    }

    if (args.priceMax) {
        filtered = filtered.filter(instrument => instrument.price <= args.priceMax);
    }

    return filtered;
}

function filterInstrumentTypes(parent, args) {
    var filtered = InstrumentTypes;

    if (args.instrumentFamily) {
        filtered = filtered.filter(type => type.family == args.instrumentFamily);
    }

    return filtered;
}

// Resolvers for type defentitions
userResolver = {
    location: (parent) => {
        return {city: parent.location};
    },

    instrumentsForSale: (parent) => {
        return Instruments.filter(instrument => instrument.sellerUserName == parent.userName);
    },
}

instrumentResolver = {
    seller: (parent) => {
        return Users.find(user => user.userName == parent.sellerUserName);
    },

    location: (parent) => {
        return {city: parent.location};
    },

    type: (parent) => {
        return InstrumentTypes.find(instrumentType => instrumentType.name == parent.type);
    }
}

locationResolver = {
    instrumentsForSale: (parent) => {
        return Instruments.filter(instrument => instrument.location == parent.city);
    },
}

instrumentTypeResolver = {
    instrumentsForSale: (parent) => {
        return Instruments.filter(instrument => instrument.type == parent.name);
    }
}

// Create resolvers object
const resolvers = {
    Query: queryResolver,
    User: userResolver,
    Instrument: instrumentResolver,
    Location: locationResolver,
    InstrumentType: instrumentTypeResolver,
}

module.exports = resolvers;