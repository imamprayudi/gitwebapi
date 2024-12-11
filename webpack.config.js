const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');

module.exports = {
    mode:'production',
    entry:{
        main:'./src/index.js',
        login:'./src/login.js',
        tinymce:'tinymce/tinymce.js',
        dashboard:'./src/dashboard.js',
        jpo:'./src/jpo.js',
        jpoc:'./src/jpoc.js',
        jpo_detail:'./src/jpo_detail.js',
        jpoc_detail:'./src/jpoc_detail.js'
        // utama:'./src/utama.js'
    },
    optimization:{
        minimizer:[
            `...`,
            new CssMinimizerPlugin()
        ],
        removeAvailableModules: true,
    },
    plugins: [ new MiniCssExtractPlugin({
        filename:'[name].bundle.css',
    }) ],
    target:'web',
    output:{
        filename:'[name].bundle.js',
        path: path.resolve(__dirname,'dist'),
        clean:true
    },
    module:{
        rules:[
            {
                test: /\.css$/i,
                use:[MiniCssExtractPlugin.loader,"css-loader"]
            },
            {
                test: /\.(?:js|mjs|cjs)$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            ['@babel/preset-env', { targets: "defaults" }]
                        ]
                    }
                }
            },
            {
                test: /\.s[ac]ss$/i,
                use: [
                    // Creates `style` nodes from JS strings
                    MiniCssExtractPlugin.loader,
                    // Translates CSS into CommonJS
                    "css-loader",
                    // Compiles Sass to CSS
                    "sass-loader",
                ],
            },
        ]
    },

}