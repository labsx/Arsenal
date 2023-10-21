import moment from "moment";

export function formatDate(value) {
    if (!value) {
        return 'none';
    }

    return moment(String(value)).format('MMMM DD, Y / dddd / h:mm A');
}

export function timeDate(value) {
    if (!value) {
       return 'none';
    }
    return moment(String(value)).format('dddd / h:mm A ');
}

export function year(value) {
    if (!value) {
    return 'none';
    }
    
    return moment(String(value)).format('Y');
}

export function formatdmy(value) {
    if (!value) {
        return 'none';
    }

    return moment(String(value)).format('DD MMMM Y');
}

