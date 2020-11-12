<div class="vg-element vg-full vg-box-shadow">
    <div class="vg-wrap vg-element vg-firm-background-color4 vg-full vg-box-shadow">
        <div class="vg-wrap vg-element vg-full">
            <div class="vg-element vg-full vg-left">
                <span class="vg-header"><?=$this->translate[$row][0] ?: $row?></span>
            </div>
            <div class="vg-element vg-full vg-left">
                <span class="vg-text vg-firm-color5"></span>
                <span class="vg_subheader"><?=$this->translate[$row][1]?></span>
            </div>
        </div>
        <div class="vg-element vg-full">
            <div class="vg-element vg-full vg-left">
                <textarea name="keywords" class="vg-input vg-text vg-full vg-firm-color1">
                    <?=isset($_SESSION['res'][$row]) ?
                        htmlspecialchars($_SESSION['res'][$row]) : htmlspecialchars($this->data[$row])?>
                </textarea>
            </div>
        </div>
    </div>
</div>