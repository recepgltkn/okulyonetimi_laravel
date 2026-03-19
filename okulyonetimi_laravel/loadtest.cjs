const fs = require('fs');
const base = 'http://127.0.0.1:8080/api/client';
const VUS = 30;
const DURATION_SEC = 180;
const IDENTIFIER = 'teacher.demo@okul.local';
const PASSWORD = '123456';

const metrics = { login:{ok:0,fail:0,status:{}}, req:{ok:0,fail:0,status:{},lat:[]} };
const add = (obj,k)=>obj[k]=(obj[k]||0)+1;
const pct=(a,p)=>{ if(!a.length) return 0; const s=[...a].sort((x,y)=>x-y); return s[Math.min(s.length-1, Math.floor((p/100)*s.length))]; };

async function jfetch(path, method='GET', body=null, token='', uid=''){
  const headers={'Content-Type':'application/json','Accept':'application/json'};
  if(token){ headers['Authorization']=`Bearer ${token}`; headers['X-Client-Token']=token; }
  if(uid) headers['X-Client-Uid']=uid;
  const t=Date.now();
  const res=await fetch(base+path,{method,headers,body:body?JSON.stringify(body):null});
  const dt=Date.now()-t;
  let json={}; try{ json=await res.json(); }catch{}
  return {status:res.status,json,dt};
}

async function login(){
  const r=await jfetch('/auth/login','POST',{identifier:IDENTIFIER,password:PASSWORD});
  add(metrics.login.status, r.status);
  if(r.status===200 && r.json?.user?.token){ metrics.login.ok++; return {uid:r.json.user.uid||r.json.user.id, token:r.json.user.token}; }
  metrics.login.fail++; return null;
}

async function vu(session, until){
  const calls=[
    ()=>jfetch('/docs/query','POST',{source:{type:'collection',path:'activities'},constraints:[]},session.token,session.uid),
    ()=>jfetch('/docs/query','POST',{source:{type:'collection',path:'contentAssignments'},constraints:[]},session.token,session.uid),
    ()=>jfetch('/docs/query','POST',{source:{type:'collection',path:'lessons'},constraints:[]},session.token,session.uid),
    ()=>jfetch('/docs/query','POST',{source:{type:'collection',path:'blockAssignments'},constraints:[]},session.token,session.uid),
    ()=>jfetch('/docs/query','POST',{source:{type:'collection',path:'computeAssignments'},constraints:[]},session.token,session.uid),
    ()=>jfetch('/docs/get?path='+encodeURIComponent('users/'+session.uid),'GET',null,session.token,session.uid),
  ];
  let i=0;
  while(Date.now()<until){
    const fn=calls[i%calls.length]; i++;
    try{
      const r=await fn();
      metrics.req.lat.push(r.dt);
      add(metrics.req.status, r.status);
      if(r.status>=200 && r.status<300) metrics.req.ok++; else metrics.req.fail++;
    }catch{
      metrics.req.fail++; add(metrics.req.status,'ERR');
    }
    await new Promise(res=>setTimeout(res, 300));
  }
}

(async()=>{
  const sessions=(await Promise.all(Array.from({length:VUS},()=>login()))).filter(Boolean);
  const until=Date.now()+DURATION_SEC*1000;
  await Promise.all(sessions.map(s=>vu(s,until)));
  const out={
    vus:VUS,
    duration_sec:DURATION_SEC,
    login:metrics.login,
    requests_total:metrics.req.ok+metrics.req.fail,
    requests_ok:metrics.req.ok,
    requests_fail:metrics.req.fail,
    status:metrics.req.status,
    latency_ms:{p50:pct(metrics.req.lat,50),p95:pct(metrics.req.lat,95),p99:pct(metrics.req.lat,99),max:Math.max(0,...metrics.req.lat)}
  };
  fs.writeFileSync('loadtest-result.json', JSON.stringify(out,null,2));
  console.log(JSON.stringify(out,null,2));
})();
