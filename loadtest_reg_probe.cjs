const base='http://127.0.0.1:8080/api/client';
(async()=>{
 const res=await fetch(base+'/auth/register',{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json'},body:JSON.stringify({email:'xx@example.com',password:'LoadTest123!',username:'xx'})});
 const j=await res.json().catch(()=>({}));
 console.log(res.status,j);
})();
