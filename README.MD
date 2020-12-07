# Holidays around the world

### ***Requirements***:

1. User should be able to search <code>public holidays</code> for a specific country and year combination.
2. A search result should contain: 
   -   public holidays list grouped by a month
   -   total amount of public holidays
   -   status(<code>workday</code>, <code>free day</code>, <code>holiday</code>) for a current day
   -   the maximum number of free(free day + holiday) days that will be in the selected country year
3. After search, country and year combination public holidays from <code>API</code> should be saved to a database, so repeated searches should not make requests to a <code>API</code> but should query a database.

***Technologies***:
- **PHP - Symfony Framework**
- **Frontend - Bootstrap**
- **Database - MySQL**

## Getting Started

### A bit about my aproach

1. For the sake of clarity and ease of maintenance, because It is required to consume an API *(which implies working with multiple <code>URL's</code>)* I decided to break down  the process of fetching data into two services: 

- ***DataService*** - implements the logic needed to perform upon a specific <code>url</code> *(in case o this project only getting the data)*.
- ***UrlService*** - inherits the DataService and implements the logic of cunstructing the needed <code>url</code> which has to be used along with it's parent logic.
  
1. In order to keep things simple in the process of getting the holidays grouped by month I decided to get all holidays by year for a specific country using <code>getHolidaysForYear</code> operation and to perform a small rearranging *(by month)* operation upon the obtained array and count the amount of holidays, free days and work days while looping through that array instead of making 12 requests *(a request for each month of the year)* using the <code>getHolidaysForMonth</code> operation and afterwards checking each holiday of the month for its status by making another request using <code>isPublicHoliday</code> or <code>isWorkDay</code> operation and thus overwhelming the API server with requests. 

### Deployed with

- Heroku

### Running

See it working at: 

      https://mighty-bayou-22915.herokuapp.com/

Or run it on your machine following the next steps:

1. Clone this repo:

         $ git clone https://github.com/draganMA/enrico_service_consumption.git   

2. Run it:

         $ cd enrico_service_consumption
      >
         $ symfony server:start
