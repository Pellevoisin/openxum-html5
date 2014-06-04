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

Kamisado.MCTSPlayer2 = function (color, engine, nSimulation) {

// public methods
    this.color = function() {
        return mycolor;
    };

    this.nSimulation = function(){
        return nSimulation;
    }

    this.root = function(){
        return root;
    }

    this.root = function(node){
        this.root = node;
    }

    function MCTSPlayer2 (color, engine, nSimulation) {
        this.color = color;
        this.nSimulation = nSimulation;
        this.engine = engine;
    }

    this.simulation = function(){
        var e;

        var current = root;
        var node = current;

        while(current != null && !current.is_finished){
            if(current.getMoves().length != 0){
                node = current;
                break;
            }
            node = current;
            current = current.select();
        }

        if(current == null || !current.is_finished){
            current = node;
            var newEngine = clone(engine);
            var m = current.getMoves()[0];
            console.log(m);
            var playable_tower = newEngine.find_playable_tower(newEngine.current_color);

            newEngine.move_tower(playable_tower,m);

            var newNode = new Kamisado.TreeNode(newEngine, current);

            //supprimer le 1er element de la liste de moves
            current.getMove().splice(0, 1);

            current.getChildNode().push(newNode);

            e = newNode.getEngine();
            current = newNode;
        }
        else{
            e = clone(current.getEngine());
        }

        while (!e.is_finished()) {
            play_a_random_turn(e, e.current_color());
        }

        while(current != null){
            current.incNi();
            if (color == e.winner_is()) {
                current.incWi();
            }
            current.getParent();
        }

    }

    function getBestMove() {
        var bestMove;
        var best = root.getChildNode()[0].ni();
        bestMove = root.getChildNode()[0].c();
        for(var i = 1; i < root.getChildNode().length; i++){
            if(root.getChildNode()[i].ni() > best){
                best = root.getChildNode()[i].ni();
                bestMove = root.getChildNode()[i].c();
            }
        }
        return bestMove;
    }

    this.getMove = function (){
        root = new Kamisado.TreeNode(null, engine);
        for(var i = 0; i < this.nSimulation(); i++){
            if((i + 1) % 500 == 0){
                console.log(i +  " : " + getBestMove());
                alert(i +  " : " + getBestMove());
            }
            this.simulation();
        }
        return getBestMove();
    }

    this.is_remote =function () {
        return false;
    };


    this.move_tower = function () {
        var playable_tower = engine.find_playable_tower(mycolor);
        engine.move_tower(playable_tower, this.getMove());
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

// private attributes
    var mycolor = color;
    var engine = engine;
    var root;
    var nSimulation = 1000;

};
/**
 * Created by binachier on 03/06/14.
 */
