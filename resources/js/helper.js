import moment from "moment";

export function formatDate(value){
    if(value){
        return moment(String(value)).format('MMMM DD, Y / dddd / h:mm A');
    }
}

export function timeDate(value){
    if(value){
        return moment(String(value)).format('dddd / h:mm A');
    }
}

