# ADHOC-Battleship
Online battleship platform for PacificMUN 2020 ADHOC Committee

Live version can be found at: http://adhoc.pacificmun.org

Pages it includes:
 - Log-in page (log in as either staff or delegate... login credentials are hard-coded since I had to rush coding the system. Not too bad because there are only 9 possible logins
 - Delegate/Agent portal page -- shows their stats (health, # of missiles, name, etc.) & battleship grid
 - Dais/Staff control panel page (shows all delegates, the grid, and includes function to change any delegates' stats)

Currently in Beta stage. Missing five things (but still functioning\*):
1. \*Special attack (when isCharged = true) "Death Ray"
2. Lives taken off automatically on hit
3. Button to reset to default system
4. Logging of every action made by delegates
5. Action completion/error notification

There are quite a few lines of code that are not too optimized, as I only had several days to complete it.

Database-y things:
 - One database (ADHOCY) with two tables (master, grid)
 - Master table contains information about the delegates and their stats
 - Grid table contains the battleship grid; A-J on the x axis, 1-10 on the y axis

Some context:
 - repo contains HTML, CSS, and PHP (+MySQL queries)
 - the file 'dbh.inc.php' merely connected the client to a database. It's been omitted from this repository because of sensitive information on it
