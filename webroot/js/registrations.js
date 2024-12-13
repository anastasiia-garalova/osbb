function viewReg(Reg,Authorize) {
    var o=document.getElementById(Reg);
    var auto=document.getElementById(Authorize);
    o.style.display = (o.style.display == 'none')? 'block': 'none';
    auto.style.display = (auto.style.display == 'none')? 'none': 'block';

    return o.style.display;
}