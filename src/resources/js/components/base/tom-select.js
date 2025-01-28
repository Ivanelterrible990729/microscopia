(function () {
    "use strict";

    // Objeto para almacenar las instancias de Tom Select
    window.tomSelectInstances = {};

    // Función para inicializar Tom Select
    window.initTomSelect = function (selector, customOptions = {}) {
        // Verificar si ya existe una instancia de Tom Select para el selector
        if (window.tomSelectInstances[selector]) {
            // Si existe, destrúyela antes de crear una nueva
            window.tomSelectInstances[selector].destroy();
        }

        // Inicializar Tom Select
        const elements = document.querySelectorAll(selector);
        elements.forEach(function (element) {
            let options = {
                plugins: {
                    dropdown_input: {},
                },
            };

            // Verificar si tiene un placeholder
            if (element.dataset.placeholder) {
                options.placeholder = element.dataset.placeholder;
            }

            // Verificar si es un multi-select
            if (element.multiple !== undefined) {
                options = {
                    ...options,
                    plugins: {
                        ...options.plugins,
                        remove_button: {
                            title: "Eliminar",
                        },
                    },
                    persist: false,
                    create: false,
                };
            }

            // Verificar si tiene un header personalizado
            if (element.dataset.header) {
                options = {
                    ...options,
                    plugins: {
                        ...options.plugins,
                        dropdown_header: {
                            title: element.dataset.header,
                        },
                    },
                };
            }

            options = { ...options, ...customOptions };

            // Crear nueva instancia de Tom Select
            window.tomSelectInstances[selector] = new TomSelect(element, options);
        });
    };
})();
