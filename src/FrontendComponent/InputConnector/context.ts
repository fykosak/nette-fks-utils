import {createContext} from 'react';

export const InputContext = createContext<InputConnectorStateMap>(null);

export interface InputConnectorStateMap {
    data: string | null;
    initialData: string | null;
    setData: (value: string) => void;
    setInitialData: (value: string) => void,
}