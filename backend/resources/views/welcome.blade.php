<form action="/test_func_index" method="POST">
    <input type="text" name="start_date" placeholder="start_date" value="1631664000">
    <input type="text" name="end_date" placeholder="end_date" value="1639699200">
    <input type="text" name="query_date" placeholder="query_date" value="1639699200">
    <input type="hidden" name="_token" id="csrf-token" value="{{csrf_token()}}" />
    <input type='submit' value="submit"/>
</form>
