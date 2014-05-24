Kamisado.Status = function () {
};

Kamisado.Manager = function (e, gui_player, other_player, s) {

// public methods
    this.play = function () {
        if (engine.phase() == Kamisado.Phase.MOVE_TOWER && gui.get_selected_tower() && gui.get_selected_cell()) {
            engine.move_tower(gui.get_selected_tower(), gui.get_selected_cell());
            gui.unselect();
        }
        gui.draw();
        finish();
        if (engine.current_color() != gui.color()) {
            if (!other.is_remote()) {
                this.play_other();
                finish();
            }
        }
    };

    this.play_other = function() {
        if (engine.phase() == Kamisado.Phase.MOVE_TOWER) {
            other.move_tower();
        }
        gui.draw();
    };

// private methods
    var finish = function() {
        if (engine.is_finished()) {
            var popup = document.getElementById("winnerModalText");

            popup.innerHTML = "<h4>The winner is " +
                (engine.winner_is() == Kamisado.Color.BLACK ? "black" : "white") + "!</h4>";
            $("#winnerModal").modal("show");
        }
    };

// private attributes
    var engine = e;
    var gui = gui_player;
    var other = other_player;
    var status = s;
};