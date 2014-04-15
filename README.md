This project implements SF movies Coding Challenge.

I chose the full stack implementation using CakePHP framework.
Probably, usage of framework for such a small project is a bit overkill 
but it gives flexibility to extend the code and easily add some features 
in the future. I'm more comfortable with backend so I decided to explore some
front end areas just for fun.

In order to use Google Map API I had to convert the addresses to latitude/longitude
manually because of it the better way to to get database is to deploy it from 
the file findMovieFilmedSF.sql which is attached to the project.

This project features quite simple front end design and minimal UI. It definitely
can be modified to provide more complex functionality. 
Some features that I had in mind:

* showing locations of a random movie
* adding link to movie's description
* showing snapshots from that movie
* showing fun facts about the movie(the data already in database)  