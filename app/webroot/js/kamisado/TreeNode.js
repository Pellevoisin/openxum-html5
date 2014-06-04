/**
 * Created by binachier on 03/06/14.
 */
Kamisado.TreeNode = function (parent, engine) {

// public methods
    this.parent = function() {
        return parent;
    };

    this.wi = function(){
        return wi;
    }

    this.ni = function(){
        return ni;
    }

    this.li = function(){
        return li;
    }

    this.incNi = function(){
        this.ni = this.ni + 1;
    }

    this.incWi = function(){
        this.wi = this.wi + 1;
    }

    this.getMoves = function(){
        return move;
    }

    this.getChildNode = function(){
        return childNode;
    }

    this.getEngine = function(){
        return engine;
    }

    this.c = function(){
        return c;
    }

    this.setC = function(val){
        this.c = val;
    }

    this.getParent = function(){
        return parent;
    }

    this.setParent = function(val){
        this.parent = val;
    }

    this.getUCB = function () {
        return (this.ni - this.wi) / this.ni + 0.2 * Math.sqrt(Math.log(parent.ni / this.ni));
    };
    this.select = function(){
        if(childNode.length == 0)
            return null;

        var selected = childNode[0];
        var best = selected.getUCB();
        for(var i = 0; i < childNode.length; i++){
            var value = childNode[i].getUCB();
            if(best < value){
                best = value;
                selected = childNode[i];
            }
        }

        return selected;
    };

    this.init = function(){
        this.move = engine.get_possible_moving_list({ x: 1, y : 4, color: Kamisado.Color.WHITE});
        if(this.move.length == 0)
            console.log("Empty List");
    }


// private attributes
    var parent = parent;
    var wi = 0;
    var li = 0;
    var ni = 0;

    var c = null;

    var move = engine.get_possible_moving_list({ x: 4, y : 1, color: Kamisado.Color.WHITE});
    var childNode  = [];


};