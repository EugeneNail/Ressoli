import { ReactElement, createContext, useContext, useState } from "react";
import "./notifications.sass";
import { Icon } from "../icon/icon";
import classNames from "classnames";

const StateContext = createContext({
  notifications: [] as Notification[],
  addNotification: (message: string, isSuccessful: boolean = true) => {},
});

type Props = {
  children: ReactElement;
};

type Notification = {
  isSuccessful: boolean;
  message: string;
};

export function Notifications({ children }: Props) {
  const [notifications, setNotifications] = useState<Notification[]>([]);

  function addNotification(message: string, isSuccessful: boolean = true) {
    const notification: Notification = {
      message,
      isSuccessful,
    };
    setNotifications([...notifications, notification]);

    setTimeout(() => {
      setNotifications(notifications.filter((item) => item !== notification));
    }, 3000);
  }

  return (
    <StateContext.Provider
      value={{
        notifications,
        addNotification,
      }}
    >
      <>
        <div className="notifications">
          {notifications.map((notification) => (
            <div
              className={classNames(
                "notification",
                { success: notification.isSuccessful },
                { error: !notification.isSuccessful }
              )}
            >
              <Icon className="notification__icon" name={notification.isSuccessful ? "check_circle" : "error"} />
              <p className="notification__message">{notification.message}</p>
            </div>
          ))}
        </div>
        {children}
      </>
    </StateContext.Provider>
  );
}

export const useNotificationContext = () => useContext(StateContext);
