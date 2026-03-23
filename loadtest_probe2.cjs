const base='http://127.0.0.1:8080/api/client';
(async()=>{
 const res=await fetch(base+'/auth/register',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({email:'probe'+Date.now()+'@okul.local',password:'LoadTest123!',username:'probe'})});
 const text=await res.text();
 console.log('status',res.status); console.log(text.slice(0,500));
})();
