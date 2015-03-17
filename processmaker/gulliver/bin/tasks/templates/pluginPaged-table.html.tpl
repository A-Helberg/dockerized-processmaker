<!-- START BLOCK : headBlock -->
<table cellpadding="0" cellspacing="0" border="0"><tr><td>
<div class="boxTop"><div class="a"></div><div class="b"></div><div class="c"></div></div>
<div class="pagedTableDefault">
  <table id="pagedtable[{pagedTable_Id}]" name="pagedtable[{pagedTable_Name}]" border="0" cellspacing="0" cellpadding="0" class="Default">
    <tr>
    <td valign="top">

      <span class='subtitle'>{title}</span>
      <table cellspacing="0" cellpadding="0" width="100%" border="0">
        <!-- START BLOCK : headerBlock -->
        <tr><td class="headerContent">{content}</td></tr>
        <!-- END BLOCK : headerBlock -->
      </table>
      <table id="table[{pagedTable_Id}]" name="table[{pagedTable_Name}]" cellspacing="0" cellpadding="0" width="100%" class="pagedTable">
<!-- END BLOCK : headBlock -->
<!-- START BLOCK : contentBlock -->
        <script type="text/javascript">{pagedTable_JS}</script>
        <tr>
          <!-- START BLOCK : headers -->
          <td class="pagedTableHeader"><img style="{displaySeparator}" src="/js/maborak/core/images/separatorTable.gif" /></td>
          <td width="{width}" style="{align}" class="pagedTableHeader">
            <a href="{href}" onclick="{onclick}">{header}</a>
          </td>
          <!-- END BLOCK : headers -->
        </tr>
        <!-- START BLOCK : row -->
        <tr class='{class}' onmouseover="setRowClass(this, 'RowPointer')" onmouseout="setRowClass(this, '{class}')">
          <!-- START BLOCK : field -->
          <td{classAttr}></td><td{classAttr}{alignAttr}>{value}</td>
          <!-- END BLOCK : field -->
        </tr>
        <!-- END BLOCK : row -->
        <!-- START BLOCK : rowTag -->
        <!-- END BLOCK : rowTag -->

        <!-- START BLOCK : norecords -->
        <tr class='Row2'>
          <td nowrap colspan="{columnCount}" align='center' >&nbsp;
            {noRecordsFound}<br>&nbsp;
          </td>
        </tr>
        <!-- END BLOCK : norecords -->

        <!-- START BLOCK : bottomFooter -->
        <tr>
          <td nowrap colspan="{columnCount}">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr class="pagedTableFooter">
                <td width="110px" style="{indexStyle}">
                  {labels:ID_ROWS}&nbsp;{firstRow}-{lastRow}/{totalRows}&nbsp;
                </td>
                <!--<td style="text-align:center;{fastSearchStyle}"><!--{labels:ID_SEARCH}
                  <input type="text" class="FormField" onkeypress="if (event.keyCode===13){pagedTableId}.doFastSearch(this.value);if (event.keyCode===13)return false;" value="{fastSearchValue}" onfocus="this.select();" size="10" style="{fastSearchStyle}"/>
                </td>-->
                <td style="text-align:center;">
                  {first}{prev}{next}{last}
                </td>
                <td width="60px" style="text-align:right;padding-right:8px;{indexStyle}">{labels:ID_PAGE}&nbsp;{currentPage}/{totalPages}</td>
              </tr>
            </table>
          </td>
        </tr>
        <!-- END BLOCK : bottomFooter -->
<!-- END BLOCK : contentBlock -->
<!-- START BLOCK : closeBlock -->
      </table>

    </td>
    </tr>
  </table>
</div>
<div class="boxBottom"><div class="a"></div><div class="b"></div><div class="c"></div></div>
</td></tr></table>
<!-- END BLOCK : closeBlock -->