<div class="container">

    <script>
        $(document).ready(function() {
            $('#winnerModal .new-game-button').click(function() {
                $('#winnerModal').modal('hide');
                window.location.href = '/openxum-html5/index.php/games/index';
            });
        });
    </script>

    <div class="modal fade" id="winnerModal" tabindex="-1" role="dialog" aria-labelledby="winnerModelLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div id="winnerModalText" class="modal-body"></div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <?php
                        echo $this->Html->Link(__('New game'), '#',
                            array('class' => 'btn btn-primary new-game-button', 'escape' => false));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="container">

    <?php
    echo $this->Html->script('kamisado/Kamisado');
    echo $this->Html->script('kamisado/Constants');
    echo $this->Html->script('kamisado/Engine');
    echo $this->Html->script('kamisado/GuiPlayer');
    echo $this->Html->script('kamisado/Manager');
    //    echo $this->Html->script('kamisado/RandomPlayer');
    //    echo $this->Html->script('kamisado/TreeNode');
    echo $this->Html->script('kamisado/MCTSMinMaxPlayer');
    //echo $this->Html->script('kamisado/MCTSPlayer');
    ?>

    <script language="javascript">
        $(document).ready(function () {
            var canvas = document.getElementById("board");
            var canvas_div = document.getElementById("boardDiv");
            var engine = new Kamisado.Engine(0, 0);
            var gui = new Kamisado.GuiPlayer(<?php echo ($color == 'black' ? 0 : 1); ?>, engine);
            var other;

            if (<?php echo $game_id; ?> == -1)
            {
                other = new Kamisado.MCTSMinMaxPlayer(<?php echo ($color == 'black' ? 1 : 0) ?>, engine);
            }

            var manager = new Kamisado.Manager(engine, gui, other);

            if (canvas_div.clientHeight < canvas_div.clientWidth) {
                canvas.height = canvas_div.clientHeight * 0.95;
                canvas.width = canvas_div.clientHeight * 0.95;
            } else {
                canvas.height = canvas_div.clientWidth * 0.95;
                canvas.width = canvas_div.clientWidth * 0.95;
            }
            gui.set_canvas(canvas);
            gui.set_manager(manager);

            if (<?php echo $game_id; ?> != -1) {
                other.set_manager(manager);
            }
            if (engine.current_color() == other.color()) {
                manager.play_other();
            }
        });
    </script>

    <!--    <?php echo 'play '.$game_id.' with '.$owner_id.' against '.$opponent_id.' with '.$color ?> -->

    <div class="row">
        <div class="col-md-12" id="boardDiv">
            <canvas id="board"
                    style="width: 600px; height: 600px; padding-left: 0; padding-right: 0; margin-left: auto; margin-right: auto; display: block; border-radius: 15px; -moz-border-radius: 15px; box-shadow: 8px 8px 2px #aaa; ">
            </canvas>
        </div>
    </div>
</div>
