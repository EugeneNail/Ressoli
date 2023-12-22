import { useState } from "react";

export type Errors<E> = {
  values: E;
  set: (newValues: E) => void;
  reset: (name: string) => void;
};

export function useErrors<E>(initial: E): Errors<E> {
  const [values, setValues] = useState(initial);

  function set(newValues: E) {
    setValues({ ...values, ...newValues });
  }

  function reset(name: string) {
    set({
      ...values,
      [name]: [],
    });
  }

  return { values, set, reset };
}
