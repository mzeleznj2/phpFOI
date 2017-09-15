<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
<style>
.datagrid table { border-collapse: collapse; text-align: left; width: 100%; } .datagrid {font: normal 12px/150% Arial, Helvetica, sans-serif; background: #fff; overflow: hidden; border: 1px solid #E4833C; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; }.datagrid table td, .datagrid table th { padding: 3px 10px; }.datagrid table thead th {background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #E4833C), color-stop(1, #E4833C) );background:-moz-linear-gradient( center top, #E4833C 5%, #E4833C 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#E4833C', endColorstr='#E4833C');background-color:#E4833C; color:#FFFFFF; font-size: 15px; font-weight: bold; border-left: 1px solid #E4833C; } .datagrid table thead th:first-child { border: none; }.datagrid table tbody td { color: #E4833C; border-left: 1px solid #E4833C;font-size: 12px;font-weight: normal; }.datagrid table tbody .alt td { background: #C2BDB8; color: #E4833C; }.datagrid table tbody td:first-child { border-left: none; }.datagrid table tbody tr:last-child td { border-bottom: none; }.datagrid table tfoot td div { border-top: 1px solid #E4833C;background: #E4833C;} .datagrid table tfoot td { padding: 0; font-size: 12px } .datagrid table tfoot td div{ padding: 2px; }.datagrid table tfoot td ul { margin: 0; padding:0; list-style: none; text-align: right; }.datagrid table tfoot  li { display: inline; }.datagrid table tfoot li a { text-decoration: none; display: inline-block;  padding: 2px 8px; margin: 1px;color: #FFFFFF;border: 1px solid #E4833C;-webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #006699), color-stop(1, #00557F) );background:-moz-linear-gradient( center top, #006699 5%, #00557F 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#006699', endColorstr='#00557F');background-color:#006699; }.datagrid table tfoot ul.active, .datagrid table tfoot ul a:hover { text-decoration: none;border-color: #006699; color: #FFFFFF; background: none; background-color:#00557F;}div.dhtmlx_window_active, div.dhx_modal_cover_dv { position: fixed !important; }
</style>
</head>
<body>
<h1>This is a Heading</h1>
<p>This is a paragraph.</p>
<div class="datagrid">
<table>
<thead>
<tr>
<th>header</th><th>header</th><th>header</th><th>header</th>
</tr>
</thead>
<tbody>
<tr>
<td>data</td><td>data</td><td>data</td><td>data</td>
</tr>
<tr class="alt">
<td>data</td><td>data</td><td>data</td><td>data</td>
</tr>
<tr>
<td>data</td><td>data</td><td>data</td><td>data</td>
</tr>
<tr class="alt">
<td>data</td><td>data</td><td>data</td><td>data</td>
</tr>
<tr>
<td>data</td><td>data</td><td>data</td><td>data</td>
</tr>
</tbody>
<tfoot>
<tr><td colspan="4">
<div id="paging">
<ul>
<li><a href="#"><span>Previous</span></a></li>
<li><a href="#" class="active"><span>1</span></a></li>
<li><a href="#"><span>2</span></a></li>
<li><a href="#"><span>3</span></a></li>
<li><a href="#"><span>4</span></a></li>
<li><a href="#"><span>5</span></a></li>
<li><a href="#"><span>Next</span></a></li>
</ul>
</div>
</tr>
</tfoot>
</table>
</div>
</body>
</html>