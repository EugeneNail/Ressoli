import { Dispatch, SetStateAction, useState } from "react";

export type EditablePageState = {
  applicableRoute: string;
  isSubmitting: boolean;
  setSubmitting: Dispatch<SetStateAction<boolean>>;
};

export function useEditablePageState(applicableRoute: string): EditablePageState {
  const [isSubmitting, setSubmitting] = useState(false);

  return { applicableRoute, isSubmitting, setSubmitting };
}
