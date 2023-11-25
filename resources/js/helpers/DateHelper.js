export class DateHelper {

    constructor() {
        Date.prototype.getMonthName = function(lang) {
            lang = lang && (lang in Date.locale) ? lang : 'en';
            return Date.locale[lang].month_names[this.getMonth()];
        };
        
        Date.prototype.getMonthNameShort = function(lang) {
            lang = lang && (lang in Date.locale) ? lang : 'en';
            return Date.locale[lang].month_names_short[this.getMonth()];
        };
        
        Date.locale = {
            en: {
               month_names: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
               month_names_short: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            }
        };
    }
    
    getDateByFilter(filter, format = 'Y-m-d')
    {
        let startDateValue = null;
        let endDateValue = null;

        if (filter.type == 'day') {

            let startDate = filter.period[0];
            let endDate = filter.period[1];

            if (filter.automatic_update) {
                startDate = new Date(new Date().setDate(new Date().getDate() - 30));
                endDate =  new Date();
            }

            startDateValue = this.formatDate(startDate, format);
            endDateValue = this.formatDate(endDate, format);

        } else if (filter.type == 'year') {

            let year = filter.year;

            startDateValue = this.formatDate(year + '-01-01 00:00:00', format);
            endDateValue = this.formatDate(year + '-12-31 23:59:59', format);

        } else if (filter.type == 'month') {

            let year = filter.year;
            let month = filter.month;

            if (filter.automatic_update) {
                year = (new Date()).getFullYear();
                month = (new Date()).getMonth();
            }

            var lastDayofMonth = new Date(year, ("0" + (month + 1)).slice(-2), 0);
            startDateValue = this.formatDate(year + '-' + ("0" + (month + 1)).slice(-2) + '-01 00:00:00', format);
            endDateValue = this.formatDate(year + '-' + ("0" + (month + 1)).slice(-2) + '-' + lastDayofMonth.getDate() + ' 23:59:59', format);
        }

        return [startDateValue, endDateValue];
    }

    formatDate(date, format = 'Y-m-d') {

        if (typeof date === 'string')
            date = new Date(date);

        if (format == 'd/m/Y')
            return  (("0" + (date.getDate())).slice(-2)) + '/' + (("0" + (date.getMonth() + 1)).slice(-2)) + '/' + date.getFullYear() ;
            
        return date.getFullYear() + '-' + (("0" + (date.getMonth() + 1)).slice(-2)) + '-' + (("0" + (date.getDate())).slice(-2));
    }
}