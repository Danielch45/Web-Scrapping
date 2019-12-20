var list_exclude = [];
function filter(source, currButton)
{
	if(list_exclude.indexOf(source) < 0)
	{
		list_exclude.push(source);
		currButton.style.backgroundColor = "white";
		currButton.style.color = "#d12317";
	}
	else
	{
		// console.log(source);
		list_exclude.splice(list_exclude.indexOf(source),1);
		currButton.style.backgroundColor = "#d12317";
		currButton.style.color = "white";
	}
	var feeds = document.getElementsByClassName("feedsContainer");
	console.log("Feeds : " + feeds.length);
	for (var i = 0; i < feeds.length; i++) 
	{
		feeds[i].style.opacity = "1";
		feeds[i].style.display = "block";
		// setTimeout(function(){feeds[i].style.opacity = "1";}, 200);
		// console.log("hehe");
	}
	var feeds_selected = [];
	var temp =[];
	console.log("list_exclude : " + list_exclude.length);
	for (var i = 0; i < list_exclude.length; i++) 
	{
		// console.log("i :" + i + " Ex : " + list_exclude[i]);
		feeds_selected = document.getElementsByClassName(list_exclude[i]);
		// console.log(feeds_selected.length);
		temp.push(feeds_selected);
		for (var j = 0; j < feeds_selected.length ; j++) 
		{
			// console.log("ada kodok");
			feeds_selected[j].style.opacity = "0";
			// console.log(temp[i][j]);
			// var temp = feeds_selected[j];
			// 
			// setTimeout(function(){console.log(temp[i][j]);temp[i][j].style.display = "none";}, 2000);
			feeds_selected[j].style.display = "none";
		}
	}
}