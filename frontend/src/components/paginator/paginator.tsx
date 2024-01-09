import classNames from "classnames";
import "./paginator.sass";
import { Icon } from "../icon/icon";
import { useSearchParams } from "react-router-dom";

type PaginatorProps = {
  lastPage: number;
  pageRadius: number;
  currentPage: number;
  className?: string;
};

export function Paginator({ className, lastPage, pageRadius, currentPage }: PaginatorProps) {
  const [_, setParams] = useSearchParams();
  const firstPage = 1;

  function goTo(page: number) {
    setParams((prev) => {
      prev.set("page", page.toString());
      return prev;
    });
  }

  function range(start: number, end: number): number[] {
    const range: number[] = [];

    for (let i = start; i <= end; i++) {
      range.push(i);
    }

    return range;
  }

  function getLeftRange(): number[] {
    const start = currentPage - pageRadius <= firstPage ? firstPage + 1 : currentPage - pageRadius;
    return range(start, currentPage - 1);
  }

  function getRightRange(): number[] {
    const end = currentPage + pageRadius >= lastPage ? lastPage - 1 : currentPage + pageRadius;
    return range(currentPage + 1, end);
  }

  return (
    <div className={classNames("paginator", className)}>
      {currentPage !== firstPage && (
        <div className="paginator__button" onClick={() => goTo(currentPage - 1)}>
          <Icon name="chevron_left" />
        </div>
      )}
      {currentPage !== firstPage && (
        <div className="paginator__button" onClick={() => goTo(firstPage)}>
          {firstPage}
        </div>
      )}
      {currentPage - pageRadius - 1 > firstPage && <div className="paginator__button">...</div>}
      {getLeftRange().map((page) => (
        <div key={page} className="paginator__button" onClick={() => goTo(page)}>
          {page}
        </div>
      ))}
      <div className="paginator__button current">{currentPage}</div>
      {getRightRange().map((page) => (
        <div key={page} className="paginator__button" onClick={() => goTo(page)}>
          {page}
        </div>
      ))}
      {currentPage + pageRadius + 1 < lastPage && <div className="paginator__button inactive">...</div>}
      {currentPage !== lastPage && (
        <div className="paginator__button" onClick={() => goTo(lastPage)}>
          {lastPage}
        </div>
      )}
      {currentPage !== lastPage && (
        <div className="paginator__button" onClick={() => goTo(currentPage + 1)}>
          <Icon name="chevron_right" />
        </div>
      )}
    </div>
  );
}
