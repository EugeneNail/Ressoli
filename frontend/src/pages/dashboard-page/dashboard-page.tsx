import { useEffect, useState } from "react";
import "./dashboard-page.sass";
import {
  LineChart,
  XAxis,
  YAxis,
  CartesianGrid,
  Line,
  ResponsiveContainer,
  BarChart,
  Bar,
  Tooltip,
  Legend,
} from "recharts";
import { Statistics } from "../../models/statistics";
import { useHttp } from "../../services/useHttp";
import { useNotificationContext } from "../../components/notifications/notifications";
import { Spinner } from "../../components/spinner/spinner";

export function DashboardPage() {
  const [statistics, setStatistics] = useState<Statistics>();
  const http = useHttp();
  const [isLoading, setLoading] = useState(true);
  const notifications = useNotificationContext();

  useEffect(() => {
    setLoading(true);
    http
      .get<Statistics>("/statistics")
      .then(({ data }) => {
        setStatistics(data);
        setLoading(false);
      })
      .catch(() => {
        notifications.addNotification("Failed to load statistics. Try reloading the page.", false);
        setLoading(false);
      });
  }, []);

  return (
    <div className="dashboard-page">
      <h1 className="dashboard-page__header">Dashboard</h1>
      {!isLoading && (
        <>
          <h3 className="dashboard-page__label">Applications during this month</h3>
          <div className="dashboard-page__grid">
            <ResponsiveContainer className="dashboard-page__chart">
              <BarChart data={statistics?.currentMonth}>
                <CartesianGrid stroke="#333" />
                <XAxis dataKey={"name"} />
                <YAxis />
                <Bar type={"monotone"} label color="#ffffff" fill="#009900" dataKey="active" />
                <Bar type={"monotone"} label={{ color: "red" }} color="#ffffff" fill="#990000" dataKey="archived" />
                <Tooltip wrapperClassName="dashboard-page__chart-score-wrapper" cursor={{ fill: "none" }} />
                <Legend />
              </BarChart>
            </ResponsiveContainer>
            <ResponsiveContainer className="dashboard-page__chart">
              <BarChart data={statistics?.currentMonth}>
                <CartesianGrid stroke="#333" />
                <XAxis dataKey={"name"} />
                <Bar type={"monotone"} label fill="#aaaa00" color="#ffffff" dataKey="price" />
                <Tooltip wrapperClassName="dashboard-page__chart-score-wrapper" cursor={{ fill: "none" }} />
                <Legend />
              </BarChart>
            </ResponsiveContainer>
          </div>
          <h3 className="dashboard-page__label">Applications during months</h3>
          <ResponsiveContainer className="dashboard-page__chart">
            <LineChart data={statistics?.monthly}>
              <CartesianGrid stroke="#333" />
              <XAxis dataKey={"name"} />
              <YAxis />
              <Line type={"monotone"} stroke="#009900" dataKey="active" />
              <Line type={"monotone"} stroke="#990000" dataKey="archived" />
              <Tooltip wrapperClassName="dashboard-page__chart-score-wrapper" cursor={{ fill: "none" }} />
              <Legend />
            </LineChart>
          </ResponsiveContainer>
          <ResponsiveContainer style={{ marginTop: "6rem" }} className="dashboard-page__chart">
            <LineChart data={statistics?.monthly}>
              <CartesianGrid stroke="#333" />
              <XAxis dataKey={"name"} />
              <YAxis />
              <Line type={"monotone"} stroke="#aaaa00" dataKey="price" />
              <Tooltip wrapperClassName="dashboard-page__chart-score-wrapper" cursor={{ fill: "none" }} />
              <Legend />
            </LineChart>
          </ResponsiveContainer>
        </>
      )}
      {isLoading && (
        <div className="dashboard-page__spinner-container">
          <Spinner className="dashboard-page__spinner" />
        </div>
      )}
    </div>
  );
}
