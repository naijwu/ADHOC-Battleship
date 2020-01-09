# ADHOC-Battleship
Online battleship platform for PacificMUN 2020 ADHOC Committee

Currently in Beta stage. Missing four things (but still fully* functioning):
1. \*Special attack (when isCharged = true) "Death Ray"
2. Lives taken off automatically on hit
3. Button to reset to default system
4. Logging of every action made by delegates

Database-y things:
 - One database (ADHOCY) with two tables (master, grid)
 - Master table contains information about the delegates and their stats
 - Grid table contains the battleship grid; A-J on the x axis, 1-10 on the y axis

Some context:
 - repo contains HTML, CSS, and PHP (+MySQL queries)
 - the file 'dbh.inc.php' merely connected the client to a database. It's been omitted from this repository because of sensitive information on it
