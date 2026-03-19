const base = 'http://127.0.0.1:8080/api/client';
async function jfetch(path, method='GET', body=null){
  const res=await fetch(base+path,{method,headers:{'Content-Type':'application/json'},body:body?JSON.stringify(body):null});
  let json={}; try{json=await res.json();}catch{}
  console.log(path,res.status,json);
}
(async()=>{
  await jfetch('/auth/register','POST',{email:'probe'+Date.now()+'@okul.local',password:'LoadTest123!',username:'probe'});
  await jfetch('/auth/login','POST',{identifier:'teacher.demo@okul.local',password:'123456'});
})();
