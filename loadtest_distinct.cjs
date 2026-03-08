const fs = require('fs');
const base = 'http://127.0.0.1:8080/api/client';
const VUS = 30;
const DURATION_SEC = 120;
const PASS = 'LoadTest123!';
const stamp = Date.now();
const users = Array.from({length:VUS},(_,i)=>({email:`load${stamp}_${i}@gmail.com`,username:`load${stamp}_${i}`,password:PASS}));

const m={reg:{ok:0,fail:0,status:{}},login:{ok:0,fail:0,status:{}},req:{ok:0,fail:0,status:{},lat:[]}};
const add=(o,k)=>o[k]=(o[k]||0)+1;
const pct=(a,p)=>{if(!a.length)return 0;const s=[...a].sort((x,y)=>x-y);return s[Math.min(s.length-1,Math.floor((p/100)*s.length))];};
async function jfetch(path, method='GET', body=null, token='', uid=''){
  const headers={'Content-Type':'application/json','Accept':'application/json'};
  if(token){headers['Authorization']=`Bearer ${token}`;headers['X-Client-Token']=token;}
  if(uid) headers['X-Client-Uid']=uid;
  const t=Date.now();
  const res=await fetch(base+path,{method,headers,body:body?JSON.stringify(body):null});
  const dt=Date.now()-t; let json={}; try{json=await res.json();}catch{}
  return {status:res.status,json,dt};
}
async function register(u){const r=await jfetch('/auth/register','POST',u);add(m.reg.status,r.status);if(r.status===201){m.reg.ok++;return true;}m.reg.fail++;return false;}
async function login(u){const r=await jfetch('/auth/login','POST',{identifier:u.email,password:u.password});add(m.login.status,r.status);if(r.status===200&&r.json?.user?.token){m.login.ok++;return {uid:r.json.user.uid||r.json.user.id,token:r.json.user.token};}m.login.fail++;return null;}
async function vu(s,until){
 const ops=[
  ()=>jfetch('/docs/query','POST',{source:{type:'collection',path:'activities'},constraints:[]},s.token,s.uid),
  ()=>jfetch('/docs/query','POST',{source:{type:'collection',path:'contentAssignments'},constraints:[]},s.token,s.uid),
  ()=>jfetch('/docs/query','POST',{source:{type:'collection',path:'lessons'},constraints:[]},s.token,s.uid),
  ()=>jfetch('/docs/query','POST',{source:{type:'collection',path:'blockAssignments'},constraints:[]},s.token,s.uid),
  ()=>jfetch('/docs/query','POST',{source:{type:'collection',path:'computeAssignments'},constraints:[]},s.token,s.uid),
  ()=>jfetch('/docs/get?path='+encodeURIComponent('users/'+s.uid),'GET',null,s.token,s.uid),
 ];
 let i=0; while(Date.now()<until){ const r=await ops[i%ops.length]().catch(()=>({status:'ERR',dt:0})); i++; if(r.dt) m.req.lat.push(r.dt); add(m.req.status,r.status); if(r.status>=200&&r.status<300)m.req.ok++; else m.req.fail++; await new Promise(res=>setTimeout(res,300)); }
}
(async()=>{
  for(const u of users){await register(u);} 
  const sessions=(await Promise.all(users.map(login))).filter(Boolean);
  const until=Date.now()+DURATION_SEC*1000;
  await Promise.all(sessions.map(s=>vu(s,until)));
  const out={vus:VUS,duration_sec:DURATION_SEC,register:m.reg,login:m.login,requests_total:m.req.ok+m.req.fail,requests_ok:m.req.ok,requests_fail:m.req.fail,status:m.req.status,latency_ms:{p50:pct(m.req.lat,50),p95:pct(m.req.lat,95),p99:pct(m.req.lat,99),max:Math.max(0,...m.req.lat)}};
  fs.writeFileSync('loadtest-result-distinct.json',JSON.stringify(out,null,2));
  console.log(JSON.stringify(out,null,2));
})();
