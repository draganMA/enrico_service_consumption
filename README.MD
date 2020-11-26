# Holidays around the world

Requirements for the Application:

1. User should be able to search <code>public holidays</code> for a specific country and year combination.
2. A search result should contain: 
   -   public holidays list grouped by a month
   -   total amount of public holidays
   -   status(<code>workday</code>, <code>free day</code>, <code>holiday</code>) for a current day
   -   the maximum number of free(free day + holiday) days that will be in the selected country year
3. After search, country and year combination public holidays from <code>API</code> should be saved to a database, so repeated searches should not make requests to a <code>API</code> but should query a database.
