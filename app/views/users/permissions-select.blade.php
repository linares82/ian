<label class="control-label">Permisos</label>
<div class="input-group">
    <span class="input-group-addon">
        <span class="glyphicon glyphicon-plus-sign add-input easyui-linkbutton" data-options="iconCls:'icon-add'"></span>
    </span>
    <select class="form-control permissions-select">
        @foreach($permissions as $permission)
        <option value="permission[{{ $permission->value }}]">{{ $permission->name }}</option>
        @endforeach
    </select>
</div>
<br>
<div class="input-container">
@if(isset($ownPermissions) && !empty($ownPermissions))
    @foreach($ownPermissions as $permission)
        <div class="form-group">
            <p class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-minus-sign remove-input easyui-linkbutton" data-options="iconCls:'icon-removes'"></span></span>
                <input readonly type="text" class="form-control" name="permission[{{ $permission->value }}]" value="{{ $permission->name }}"/>
            </p>
        </div>
    @endforeach
@endif
</div>
<br>