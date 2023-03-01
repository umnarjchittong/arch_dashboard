<?php

function panel_personal_info_card($title, $val, $percent, $icon)
{
?>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-md mb-0 text-capitalize font-weight-bold"><?= $title ?></p>
                            <h5 class="font-weight-bolder mb-0">
                                <?= $val . " คน" ?>
                            </h5>
                            <span class="text-success text-sm font-weight-bolder"><?= $percent ?></span>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="<?= $icon ?> text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
}

function panel_personal_info()
{
?>
    <div class="row">
        <?php panel_personal_info_card("บุลากรทั้งหมด", "51", "100%", "ni ni-money-coins"); ?>
        <?php panel_personal_info_card("ลาศึกษาต่อ", "3", "6%", "ni ni-world"); ?>
        <?php panel_personal_info_card("น.ศ.ทั้งหมด", "300", "100%", "ni ni-paper-diploma"); ?>
        <?php panel_personal_info_card("น.ศ.ตกค้าง", "10", "3%", "ni ni-cart"); ?>
    </div>


<?php
}





?>