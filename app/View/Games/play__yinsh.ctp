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
    echo $this->Html->script('yinsh/Yinsh');
    echo $this->Html->script('yinsh/Constants');
    echo $this->Html->script('yinsh/Coordinates');
    echo $this->Html->script('yinsh/Engine');
    echo $this->Html->script('yinsh/GuiPlayer');
    echo $this->Html->script('yinsh/Intersection');
    echo $this->Html->script('yinsh/Manager');
    echo $this->Html->script('yinsh/RandomPlayer');
    echo $this->Html->script('yinsh/RemotePlayer');
    ?>

    <script language="javascript">
        $(document).ready(function () {
            var canvas = document.getElementById("board");
            var canvas_div = document.getElementById("boardDiv");
            var markerNumber = document.getElementById("markerNumber");
            var turnList = document.getElementById("turnList");
            var engine = new Yinsh.Engine(Yinsh.GameType.BLITZ, Yinsh.Color.BLACK);
            var gui = new Yinsh.GuiPlayer(<?php echo ($color == 'black' ? 0 : 1); ?>, engine);
            var other;

            if (<?php echo $game_id; ?> ===
            -1
            )
            {
                other = new Yinsh.RandomPlayer(<?php echo ($color == 'black' ? 1 : 0) ?>, engine);
            }
            else
            {
                other = new Yinsh.RemotePlayer(<?php echo ($color == 'black' ? 1 : 0) ?>, engine, <?php echo $owner_id; ?>,
                    <?php echo $opponent_id; ?>, <?php echo $game_id; ?>);
            }

            var manager = new Yinsh.Manager(engine, gui, other, new Yinsh.Status(markerNumber, turnList));

            if (canvas_div.clientHeight < canvas_div.clientWidth) {
                canvas.height = canvas_div.clientHeight * 0.95;
                canvas.width = canvas_div.clientHeight * 0.95;
            } else {
                canvas.height = canvas_div.clientWidth * 0.95;
                canvas.width = canvas_div.clientWidth * 0.95;
            }
            gui.set_canvas(canvas);
            gui.set_manager(manager);

            if (<?php echo $game_id; ?> !==
            -1
            )
            {
                other.set_manager(manager);
            }
        });
    </script>

    <!--    <?php echo 'play '.$game_id.' with '.$owner_id.' against '.$opponent_id.' with '.$color ?> -->

    <div class="row">
        <div class="col-md-3 visible-md visible-lg">
            <table style="width: 100%; height: 100%; table-layout: fixed; padding: 10px">
                <tr style="height: 50px">
                    <td>
                        <span id="markerNumber"></span>
                    </td>
                </tr>
                <tr style="vertical-align: top;">
                    <td>
                        <span id="turnList" style="display:block; overflow: auto"></span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-9" id="boardDiv">
            <canvas id="board"
                    style="width: 500px; height: 500px; padding-left: 0; padding-right: 0; margin-left: auto; margin-right: auto; display: block; border-radius: 15px; -moz-border-radius: 15px; box-shadow: 8px 8px 2px #aaa; ">
            </canvas>
        </div>
    </div>
</div>
