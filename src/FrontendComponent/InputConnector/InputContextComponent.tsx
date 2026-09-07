import {InputContext} from './reducer';
import * as React from 'react';
import { useEffect, useState} from 'react';

interface InputContextComponentProps {
    input: HTMLInputElement | HTMLSelectElement;
    children: React.ReactNode;
}

export function InputContextComponent({input, children}: InputContextComponentProps) {
    const [{value, initialValue}, setInputValue] = useState<{ value: string, initialValue: string }>({
        value: null,
        initialValue: null
    });

    useEffect(() => {
        input.style.display = 'none';
        input.required = false;
        const label = input.parentElement.getElementsByTagName('label')[0];
        if (label && label instanceof HTMLLabelElement) {
            label.style.display = 'none';
        }
    }, []);
    return <InputContext.Provider
        value={{
            initialData: initialValue,
            data: value,
            setInitialData: (value: string): void => setInputValue({value: value, initialValue: value}),
            setData: (value: string): void => setInputValue({value: value, initialValue})
        }}>
        {children}
    </InputContext.Provider>
}