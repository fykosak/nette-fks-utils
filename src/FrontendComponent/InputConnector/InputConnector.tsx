import {useEffect,useContext} from 'react';
import {InputContext} from "./context";

export interface Props {
    input: HTMLInputElement | HTMLSelectElement;
}

export function InputConnector({input}: Props) {

    const {data, setInitialData} = useContext(InputContext);
    useEffect(() => {
        if (input.value) {
            setInitialData(input.value)
        }
    }, []);
    useEffect(() => {
        input.value = data ? data.toString() : null;
        input.dispatchEvent(new Event('change'));
    }, [data]);
    return null;
}
