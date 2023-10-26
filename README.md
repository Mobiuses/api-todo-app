<h3>TODO api test task</h2>

1) Build the project: ``make build``

<pre>
POST      api/auth/login {name:test, password:password}  
GET|HEAD  api/tasks   
POST      api/tasks   
PUT       api/tasks/{task}  
PATCH     api/tasks/{task}   
DELETE    api/tasks/{task}
</pre>
