const path = require('path');

module.exports = {
  entry: './src/GrpcClient.js',
  output: {
    filename: 'GrpcMessageClient.js',
    path: path.resolve(__dirname, 'dist'),
    library: 'GrpcMessageClient',
    libraryTarget: 'umd',
    umdNamedDefine: true,
    globalObject: 'this',
  },
  mode: 'production',
  resolve: {
    extensions: ['.js'],
  },
};
