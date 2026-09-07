import {NetteActions} from '../NetteActions/NetteActions';

export interface Message {
    level: string;
    text: string;
}

export interface DataResponse<Data> {
    actions: NetteActions;
    data: Data;
    messages: Message[];
}
