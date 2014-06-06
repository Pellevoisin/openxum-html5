function clone(obj) {
    // Handle the 3 simple types, and null or undefined
    if (null == obj || "object" != typeof obj) return obj;

    // Handle Date
    if (obj instanceof Date) {
        var copy = new Date();
        copy.setTime(obj.getTime());
        return copy;
    }

    // Handle Array
    if (obj instanceof Array) {
        var copy = [];
        for (var i = 0, len = obj.length; i < len; i++) {
            copy[i] = clone(obj[i]);
        }
        return copy;
    }

    // Handle Object
    if (obj instanceof Object) {
        var copy = {};
        for (var attr in obj) {
            if (obj.hasOwnProperty(attr)) copy[attr] = clone(obj[attr]);
        }
        return copy;
    }

    throw new Error("Unable to copy obj! Its type isn't supported.");
}

Kamisado.MCTSMinMaxPlayer = function (color, engine) {
    // public methods
    this.color = function(){
        return mycolor;
    };
    this.is_remote = function(){
        return false;
    };



   var  max_val = -1000;

    this.move_tower = function(){
        var playable_tower = engine.find_playable_tower(mycolor);

        if(!playable_tower){
            playable_tower = {x : Math.floor(Math.random() * 8), y :0};
        }

        var list = engine.get_possible_moving_list({x: playable_tower.x, y : playable_tower.y, color : mycolor});

        if(list.length != 0)
        {
            //console.log(list);
            for (var i = 0; i < list.length; ++i) {
                //console.log(list[i]);
              var e = clone(engine);
                e.move_tower(playable_tower, list[i]);
              var val_fils = ValeurMini(e, e.current_color());
              if(val_fils > max_val)
              {
                  max_val = val_fils;
                  var index = i;
              }
            }
        engine.move_tower(playable_tower, list[index]);
        }else{
            return undefined;
        }
    };

    //private method

    var ValeurMini = function(e, color){
        var e2 = clone(e);
        if(color == e2.winner_is())
        {
            return 1000000;
        }
        else
        {
            var playable_tower2 = e2.find_playable_tower(color);
            if(!playable_tower2){
                playable_tower2 = {x : Math.floor(Math.random() * 8), y :0};
            }
            var list2= e2.get_possible_moving_list({x: playable_tower2.x, y : playable_tower2.y, color : color});

            var v_min = max_val;
            console.log(list2);
            for (var i = 0; i< list2.length; ++i)
            {
                var e3 = clone(e2);

                e3.move_tower(playable_tower2, list2[i]);
                var v_fils = ValeurMax(e3, e3.current_color());
                v_min = min(v_min, v_fils)
            }
        }
        return v_min;
    };

    var ValeurMax = function(e, color){
        var e2 = clone(e);
        if(color == e2.winner_is()){
            return -1000000;
        }
        else{
            var playable_tower2 = e2.find_playable_tower(color);
            if(!playable_tower2){
                playable_tower2 = {x : Math.floor(Math.random() * 8), y :0};
            }
            var list2= e2.get_possible_moving_list({x: playable_tower2.x, y : playable_tower2.y, color : color});

            var v_max = -max_val;
            for(var i = 0;i< list2.length; ++i)
            {
                var e3 = clone(e2);
                e3.move_tower(playable_tower2, list2[i]);
                var v_fils = ValeurMini(e3, e3.current_color());
                v_max = max(v_max, v_fils);
            }
        }
        return v_max;
    };

    var max = function(a, b){
        if(a > b) return a;
        else if(a < b) return b;
        else return a;
    };
    var min = function(a, b){
        if(a > b) return b;
        else if(a < b) return a;
        else return a;
    };

// private attributes
    var mycolor = color;
    var engine = engine;


};

/*
Kamisado.MCTSPlayer = function (color, engine) {

// public methods
    this.color = function() {
        return mycolor;
    };

    this.is_remote =function () {
        return false;
    };

    this.move_tower = function () {
        var playable_tower = engine.find_playable_tower(mycolor);

        if (!playable_tower) {
            playable_tower = { x: Math.floor(Math.random() * 8), y: 0 };
        }

        var list = engine.get_possible_moving_list({ x: playable_tower.x, y: playable_tower.y, color: mycolor });

        if (list.length != 0) {
            var max = 0;
            var index = -1;

            for (var i = 0; i < list.length; ++i) {
                var e = clone(engine);
                var score = process_turn(e, playable_tower, list[i]);

                if (score > max) {
                    max = score;
                    index = i;
                }
            }
            engine.move_tower(playable_tower, list[index]);
            return list[index];
        } else {
            return undefined;
        }
    };

// private methods
    var process_turn = function (e, playable_tower, coordinates) {
        var score = 0;
        e.move_tower(playable_tower, coordinates);
        for (var i = 0; i < 1000; ++i) {
            var e2 = clone(e);

            while (!e2.is_finished()) {
                play_a_random_turn(e2, e2.current_color());
            }
            if (color == e2.winner_is()) {
                ++score;
            }
        }
        return score;
    };

    var play_a_random_turn = function (e, color) {
        var playable_tower = e.find_playable_tower(color);

        if (!playable_tower) {
            playable_tower = { x: Math.floor(Math.random() * 8), y: 0 };
        }

        var list = e.get_possible_moving_list({ x: playable_tower.x, y: playable_tower.y, color: color });
        var coordinates = list[Math.floor(Math.random() * list.length)];

        e.move_tower(playable_tower, coordinates);
    };
*/
// private attributes
   // var mycolor = color;
   // var engine = engine;
//};

