import {defineConfig} from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';
// import {createStyleImportPlugin} from 'vite-plugin-style-import';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app-jetstream.css',
                'resources/css/app.css',
                'resources/css/fullcalendar.css',
                'resources/js/app.js',
                'resources/js/fullcalendar.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
        }),
        // createStyleImportPlugin({
        //     libs: [
        //         {
        //             libraryName: 'bootstrap',
        //             esModule: true,
        //             ensureStyleFile: true,
        //             resolveStyle: (name) => `bootstrap/dist/css/${name}.css`,
        //         },
        //         {
        //             libraryName: 'bootstrap-icons',
        //             esModule: true,
        //             resolveStyle: (name) => `bootstrap-icons/font/${name}.css`,
        //         },
        //     ]
        // })
    ],
});
