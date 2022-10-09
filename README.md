# Full Stack Test

### _Tom RIpp_

## Q1.

> Given a SQL database with the following table full of data  
> CREATE TABLE countries (  
> $nbsp;$nbsp;code CHAR(2) NOT NULL,  
> $nbsp;$nbsp;year INT NOT NULL,  
> $nbsp;$nbsp;gdp_per_capita DECIMAL(10, 2) NOT NULL,  
> $nbsp;$nbsp;govt_debt DECIMAL(10, 2) NOT NULL  
> );

> Please write the SQL statement to show the top 3 average government debts in percent of the
> gdp_per_capita (govt_debt/gdp_per_capita) for those countries of which gdp_per_capita was over
> 40,000 dollars in every year in the last four years.

**_Answer_:**

```
SELECT code,AVG(govt_debt) AS average_gov_debt, (SELECT SUM(gdp_per_capita) FROM countries WHERE
gdp_per_capita > 40000 AND year >= YEAR(CURDATE()) - 4) AS sum_of_all_over_40k,
ROUND((AVG(govt_debt)/(SELECT SUM(gdp_per_capita) FROM countries WHERE gdp_per_capita > 40000 AND
year >= YEAR(CURDATE()) - 4))*100,2) AS percent_of_all_over_40k FROM countries WHERE gdp_per_capita > 40000
AND year >= YEAR(CURDATE()) - 4 GROUP BY code ORDER BY AVG(govt_debt) DESC LIMIT 3
```
