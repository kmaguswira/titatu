# TITATU : Online Multiplayer Game Tic Tac Toe

![TITATU](https://raw.githubusercontent.com/kmaguswira/titatu/master/titatu.png)

Tic-tac-toe (also known as noughts and crosses or Xs and Os) is a paper-and-pencil game for two players, X and O, who take turns marking the spaces in a 3×3 grid. The player who succeeds in placing three of their marks in a horizontal, vertical, or diagonal row wins the game. Now ready for online multiplayer. Watch [demo].

# Features!

 - Multiplayer (1 vs 1) 
 - There are lobby where player hang around and chat with other players and rooms where the game happen
 - Can create room or join room 
 - Can show list rooms,the players inside certain room, leaderboard, and a player statistic 
 - Join room using passphrase or open for public
 - There are two contestants and max 10 spectators
 - Contestants are the first two player that enter a room 
 - Contestants can start, pause, and withdraw game 
 - Contestant only have 30s to make a move, over 30s means withdraw game 
 - To make a move use column (A,B,C) and row (1,2,3) representation, e.g. A3 
 - Win 15 point, draw 10 point, lose 5 point 


### Installation

TITATU requires [PHP](http://php.net) v>=5.5.9 and [Composer](https://getcomposer.org) to run.


```sh
$ git clone https://github.com/kmaguswira/titatu.git
$ cd titatu
$ php composer.phar install
$ php artisan migrate
```

Open browser, visit localhost/titatu/public. For more detail, watch the [demo] video.



   [node.js]: <http://nodejs.org>
   [@tjholowaychuk]: <http://twitter.com/tjholowaychuk>
   [express]: <http://expressjs.com>
   [mongoose]: <https://github.com/Automattic/mongoose>
   [demo]: <https://www.youtube.com/watch?v=kb8HwQECo7o>


  
