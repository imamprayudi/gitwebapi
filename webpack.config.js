import path from 'path';
import { fileURLToPath } from 'url';
import MiniCssExtractPlugin from 'mini-css-extract-plugin';
import CssMinimizerPlugin from 'css-minimizer-webpack-plugin';

// Untuk mendapatkan __dirname dalam ES Module
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

export default {
    mode: 'production',
    entry: {
        main: './resources/src/index.js',
        // login: './resources/src/login.js',
        // dashboard: './resources/src/dashboard.js',
        jpo: './resources/src/jpo.js',
        // jpoc: './resources/src/jpoc.js',
        // jpo_detail: './resources/src/jpo_detail.js',
        // jpoc_detail: './resources/src/jpoc_detail.js'
    },
    optimization: {
        minimizer: [
            `...`,
            new CssMinimizerPlugin()
        ],
        removeAvailableModules: true,
    },
    plugins: [new MiniCssExtractPlugin({
        filename: '[name].bundle.css',
    })],
    target: 'web',
    output: {
        filename: '[name].bundle.js',
        path: path.resolve(__dirname, './dist'),
        clean: true
    },
    module: {
        rules: [
            {
                test: /\.css$/i,
                use: [MiniCssExtractPlugin.loader, "css-loader"]
            },
            {
                test: /\.(?:js|mjs|cjs)$/i,
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
                    MiniCssExtractPlugin.loader,
                    "css-loader",
                    "sass-loader",
                ],
            },
        ]
    },
};