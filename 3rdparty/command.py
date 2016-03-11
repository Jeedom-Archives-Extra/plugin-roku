#!/usr/bin/env python
from roku import Roku
import sys

def back():
	result=roku.back()
	return result

def backspace():
	result=roku.backspace()
	return result

def down():
	result=roku.down()
	return result

def enter():
	result=roku.enter()
	return result

def forward():
	result=roku.forward()
	return result

def home():
	result=roku.home()
	return result

def info():
	result=roku.info()
	return result

def left():
	result=roku.left()
	return result

def literal():
	result = roku.literal(sys.argv[3])
	return result

def play():
	result=roku.play()
	return result

def replay():
	result=roku.replay()
	return result

def reverse():
	result=roku.reverse()
	return result

def right():
	result=roku.right()
	return result

def search():
	result=roku.search()
	return result

def select():
	result=roku.select()
	return result

def up():
	result=roku.up()
	return result

def volumeup():
	result=roku.volumeup()
	return result

def volumedown():
	result=roku.volumedown()
	return result

def channel():
	channel = roku[sys.argv[3]]
	result = channel.launch()
	return result

def volumemute():
	result=roku.volumemute()
	return result

actions = {"back" : back,
			"backspace" : backspace,
			"down" : down,
			"enter" : enter,
			"forward" : forward,
			"home" : home,
			"info" : info,
			"left" : left,
			"literal" : literal,
			"play" : play,
			"replay" : replay,
			"reverse" : reverse,
			"right" : right,
			"search" : search,
			"select" : select,
			"up" : up,
			"volumeup" : volumeup,
			"volumedown" : volumedown,
			"volumemute" : volumemute,
			"channel" : channel
}
roku = Roku(sys.argv[1])
actions[sys.argv[2]]()
