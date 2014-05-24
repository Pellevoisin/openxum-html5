Kamisado.Engine = function (type, color) {

// public methods
    this.current_color = function () {
        return current_color;
    };

    this.find_playable_tower = function(color) {
        var playable_tower=  undefined;

        if (play_color) {
            var list = get_towers(color);

            for (var i = 0; i < 8; ++i) {
                if (list[i].color == play_color) {
                    playable_tower = { x: list[i].x, y: list[i].y };
                }
            }
        }
        return playable_tower;
    };

    this.get_black_towers = function() {
        return black_towers;
    };

    this.get_current_towers = function() {
        return  current_color == Kamisado.Color.BLACK ? black_towers : white_towers;
    };

    this.get_play_color = function() {
        return play_color;
    };

    this.get_white_towers = function() {
        return white_towers;
    };

    this.get_possible_moving_list = function(tower) {
        var list = [];
        var step = tower.color == Kamisado.Color.BLACK ? 1 : -1;
        var limit = tower.color == Kamisado.Color.BLACK ? 8 : -1;

        // column
        var line = tower.y + step;

        while (line != limit && is_empty({x: tower.x, y: line })) {
            list.push({x: tower.x, y: line });
            line += step;
        }

        // right diagonal
        var col = tower.x + 1;

        line = tower.y + step;
        while (line != limit && col != 8 && is_empty({x: col, y: line })) {
            list.push({x: col, y: line });
            line += step;
            ++col;
        }

        // left diagonal
        col = tower.x - 1;
        line = tower.y + step;
        while (line != limit && col != -1 && is_empty({x: col, y: line })) {
            list.push({x: col, y: line });
            line += step;
            --col;
        }
        return list;
    };

    this.is_finished = function () {
        return phase == Kamisado.Phase.FINISH;
    };

    this.move_tower = function(selected_tower, selected_cell) {
        var tower = find_tower(selected_tower, current_color);

        if (tower) {
            tower.x = selected_cell.x;
            tower.y = selected_cell.y;
        }
        if ((current_color == Kamisado.Color.BLACK && tower.y == 7) ||
            (current_color == Kamisado.Color.WHITE && tower.y == 0)) {
            phase = Kamisado.Phase.FINISH;
        } else {
            play_color = Kamisado.colors[tower.x][tower.y];
            if (!this.pass(next_color(current_color))) {
                change_color();
            } else {
                var playable_tower = this.find_playable_tower(next_color(current_color));

                play_color = Kamisado.colors[playable_tower.x][playable_tower.y];
                if (this.pass(current_color)) {
                    phase = Kamisado.Phase.FINISH;
                    current_color = next_color(current_color);
                }
            }
        }
    };

    this.pass = function(color) {
        var playable_tower = this.find_playable_tower(color);
        var list = this.get_possible_moving_list({ x: playable_tower.x, y: playable_tower.y, color: color });

        return list.length == 0;
    };

    this.phase = function() {
        return phase;
    };

    this.winner_is = function () {
        if (this.is_finished()) {
            return current_color;
        } else {
            return false;
        }
    };

// private methods
    var change_color = function () {
        current_color = next_color(current_color);
    };

    var find_tower = function(coordinates, color) {
        var tower;
        var list = color == Kamisado.Color.BLACK ? black_towers : white_towers;
        var found = false;
        var i = 0;

        while (i < 8 && !found) {
            if (list[i].x == coordinates.x && list[i].y == coordinates.y) {
                tower = list[i];
                found = true;
            } else {
                ++i;
            }
        }
        return tower;
    };

    var get_towers = function(color) {
        return  color == Kamisado.Color.BLACK ? black_towers : white_towers;
    };

    var is_empty = function(coordinates) {
        var found = false;
        var i = 0;

        while (i < 8 && !found) {
            if (black_towers[i].x == coordinates.x && black_towers[i].y == coordinates.y) {
                found = true;
            } else {
                ++i;
            }
        }
        i = 0;
        while (i < 8 && !found) {
            if (white_towers[i].x == coordinates.x && white_towers[i].y == coordinates.y) {
                found = true;
            } else {
                ++i;
            }
        }
        return !found;
    };

    var init = function() {
        black_towers = [];
        for (var i = 0; i < 8; ++i) {
            black_towers[i] = { x: i, y: 0, color: Kamisado.colors[i][0] };
        }
        white_towers = [];
        for (var i = 0; i < 8; ++i) {
            white_towers[i] = { x: i, y: 7, color: Kamisado.colors[i][7] };
        }
        phase = Kamisado.Phase.MOVE_TOWER;
        current_color = Kamisado.Color.BLACK;
        play_color = undefined;
    };

    var next_color = function(color) {
        return color == Kamisado.Color.WHITE ? Kamisado.Color.BLACK : Kamisado.Color.WHITE
    };

// private attributes
    var type = type;
    var current_color = color;

    var black_towers;
    var white_towers;
    var play_color;

    var phase;

    init();
};
