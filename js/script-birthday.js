/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    /*for birthday date*/
    $(document).ready(function() {
        'use strict';
        CURDATE = new Date();
        var minyears = CURDATE.getFullYear() - 100;

        var fromDay = $('#fromDay'),
                fromMonth = $('#fromMonth'),
                fromYear = $('#fromYear'),
                toDay = $('#toDay'),
                toMonth = $('#toMonth'),
                toYear = $('#toYear'),
                reset = $('#reset'),
                CURDATE = new Date(),
                curFromDate,
                curToDate,
                MINYEAR = minyears,
                NUMYEARS = 101,
                MAXYEAR = MINYEAR + NUMYEARS - 1,
                MAXDATE = new Date(MAXYEAR, 11, 31),
                MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        function maxDay(params) { // {month, year}

            params.month = params.month || 0;
            params.year = params.year || MINYEAR;

            return new Date(params.year, (params.month - 0) + 1, 0).getDate();
        }

        function createAry(params) { // { min, max, values }

            var i,
                    ary = [];

            params.values = params.values || [];

            if (params.values.length !== 0) {
                return params.values.slice(params.min, params.max + 1);
            }

            for (i = 0; i < params.max - params.min + 1; i++) {
                ary[i] = params.min + i;
            }

            return ary;
        }

        function days(params) { // {minDay, month, year}

            var max;

            params.month = params.month || 0;
            params.year = params.year || MINYEAR;

            max = maxDay({
                month: params.month,
                year: params.year
            });

            params.minDay = params.minDay || 1;

            return createAry({
                min: params.minDay,
                max: max
            });
        }

        function months(params) { // {minMonth, months}

            params.minMonth = params.minMonth || 0;

            return createAry({
                min: params.minMonth,
                max: 11,
                values: MONTHS
            })
        }

        function years(params) { // {minYear}

            params.minYear = params.minYear || MINYEAR;

            return createAry({
                min: params.minYear,
                max: MAXYEAR
            });
        }

        function updateSelectOptions(params) { // {select, options, current]

            params.select.empty();

            params.options.forEach(function(e, i) {
                params.select.append($('<option></option>').prop("selected", i === params.current).text(e));
            });

        }

        function updateTos() {

            var minDay = 1,
                    minMonth = 0,
                    minYear = curFromDate.getFullYear();

            if (curToDate <= curFromDate) {
                curToDate = new Date(curFromDate.getFullYear(), curFromDate.getMonth(), curFromDate.getDate() + 1);

                minYear = curToDate.getFullYear();

                if (minYear === curFromDate.getFullYear()) {
                    minMonth = curToDate.getMonth();
                }
                if (curFromDate.getMonth() === curToDate.getMonth()) {
                    minDay = curToDate.getDate();
                }
            } else if (curFromDate.getFullYear() === curToDate.getFullYear()) {
                minMonth = curFromDate.getMonth();
                if (curFromDate.getMonth() === curToDate.getMonth()) {
                    minDay = curFromDate.getDate() + 1;
                }
            } else if (curFromDate.getDate() === 31 && curFromDate.getMonth() === 11) {
                minYear++;
            }

            updateSelectOptions({
                select: toDay,
                options: days({
                    minDay: minDay,
                    month: curToDate.getMonth(),
                    year: curToDate.getFullYear()
                }),
                current: curToDate.getDate() - minDay
            });
            updateSelectOptions({
                select: toMonth,
                options: months({
                    minMonth: minMonth,
                    months: MONTHS
                }),
                current: curToDate.getMonth() - minMonth
            });
            updateSelectOptions({
                select: toYear,
                options: years({
                    minYear: minYear
                }),
                current: curToDate.getFullYear() - minYear
            });
        }

        function update(params) { // {toOrFrom}

            var day,
                    month,
                    year,
                    max,
                    date;

            if (params.toOrFrom === 'from') {
                day = fromDay.find("option:selected").text();
                month = MONTHS.indexOf(fromMonth.find("option:selected").text());
                year = fromYear.find("option:selected").text();
            } else {
                day = toDay.find("option:selected").text();
                month = MONTHS.indexOf(toMonth.find("option:selected").text());
                year = toYear.find("option:selected").text();
            }
            max = maxDay({
                month: month,
                year: year
            });

            if (day > max) {
                day = max;
            }
            date = new Date(year, month, day);

            if (params.toOrFrom === 'from') {
                if (date >= MAXDATE) {
                    fromDay.prop("selectedIndex", curFromDate.getDate() - 1);
                    fromMonth.prop("selectedIndex", curFromDate.getMonth());
                    fromYear.prop("selectedIndex", curFromDate.getFullYear() - MINYEAR);

                    return;
                }
                curFromDate = date;

                updateSelectOptions({
                    select: fromDay,
                    options: days({
                        minDay: 1,
                        month: month,
                        year: year
                    }),
                    current: day - 1
                });

            } else {
                curToDate = date;
            }
            updateTos();
        }

        function onFromChange() {
            update({
                toOrFrom: 'from'
            });
        }

        function onToChange() {
            update({
                toOrFrom: 'to'
            });
        }

        function init() {
            curFromDate = new Date(CURDATE.getFullYear(), CURDATE.getMonth(), CURDATE.getDate());
            curToDate = new Date(CURDATE.getFullYear(), CURDATE.getMonth(), CURDATE.getDate());

            updateSelectOptions({
                select: fromDay,
                options: days({
                    minDay: 1,
                    month: curFromDate.getMonth(),
                    year: curFromDate.getFullYear()
                }),
                current: curFromDate.getDate() - 1
            });
            updateSelectOptions({
                select: fromMonth,
                options: months({
                    months: MONTHS
                }),
                current: curFromDate.getMonth()
            });
            updateSelectOptions({
                select: fromYear,
                options: years({
                    minYear: MINYEAR
                }),
                current: curFromDate.getFullYear() - MINYEAR
            });

            updateTos();
        }

        fromDay.change(onFromChange);
        fromMonth.change(onFromChange);
        fromYear.change(onFromChange);
        toDay.change(onToChange);
        toMonth.change(onToChange);
        toYear.change(onToChange);
        reset.click(init);

        init();

        for (var i = 0; i < document.getElementById('fromMonth').options.length; i++)
        {
            document.getElementById('fromMonth').options[i].value = i + 1;
        }

        for (var i = 0; i < document.getElementById('fromDay').options.length; i++)
        {
            document.getElementById('fromDay').options[i].value = i + 1;
        }
        
        for (var i = 0; i < document.getElementById('fromYear').options.length; i++)
        {
            document.getElementById('fromYear').options[i].value = document.getElementById('fromYear').options[i].text; 
        }
    });