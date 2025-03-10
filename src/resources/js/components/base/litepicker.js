(function () {
    "use strict";

    // Litepicker
    $(".datepicker").each(function () {
        let options = {
            lang: 'es-ES',
            autoApply: false,
            singleMode: false,
            numberOfColumns: 2,
            numberOfMonths: 2,
            showWeekNumbers: true,
            format: "D MMM, YYYY",
            dropdowns: {
                minYear: 1990,
                maxYear: null,
                months: true,
                years: true,
            },
            buttonText: {
                apply: 'Aplicar',
                cancel: 'Cancelar',
            },
            tooltipText: {
                one: 'día',
                other: 'días',
            },
        };

        if ($(this).data("single-mode")) {
            options.singleMode = true;
            options.numberOfColumns = 1;
            options.numberOfMonths = 1;
        }

        if ($(this).data("format")) {
            options.format = $(this).data("format");
        }

        if (!$(this).val()) {
            let date = dayjs().format(options.format);
            date += !options.singleMode
                ? " - " + dayjs().add(1, "month").format(options.format)
                : "";
            $(this).val(date);
        }

        new Litepicker({
            element: this,
            ...options,
        });
    });
})();
