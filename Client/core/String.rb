#Elten Code
#Copyright (C) 2014-2016 Dawid Pieper
#All rights reserved.


#Open Public License is used to licensing this app!

class String
  def delline(lines=1)
    self.gsub!("\004LINE\004","\r\n")    
    str = ""
foundlines = 1
    for i in 0..self.size - 1
      str += self[i..i]
      foundlines += 1 if self[i..i] == "\n"
    end
    fl = 0
    ret = ""
    for i in 0..str.size - 1
      fl += 1 if str[i..i] == "\r" or (str[i..i] == "\n" and str[i-1..i-1] != "\r")
      if foundlines - lines > fl
        ret += str[i..i]
        end
      end
      return ret.to_s
    end
    def strbyline
str = self
  byline = []
  index = 0
  byline[index] = ""
  for i in 0..str.size - 1
    if str[i..i] != "\n" and str[i..i] != "\r"
    byline[index] += str[i..i]
  elsif str[i..i] == "\n"
    index += 1
    byline[index] = ""
    end
  end
  return byline
end
def rdelete!(i)
    b = i[0]
  x = 0
  for i in 1..self.size
    if self[self.size - i] == b
      x += 1
    else
      break
    end
       end
  for i in 1..x
    chop!
    end
  end
  def maintext
    str = ""
    for i in 0..self.size - 1
            str += self[i..i]
            break if self[i+1..i+1] == "\003"
    end
    return str
  end
  def lore
    str = ""
    s = false
    for i in 0..self.size - 1
            str += self[i..i] if s == true
            s = true if self[i..i] == "\003"
    end
    return str
  end
  def b
    o = []
    for i in 0..self.size - 1
      o.push(" "[self[i]])
    end
    return o
    end
  def urlenc(binary=false)
    string = self+""
    string.gsub!("%","%25") if string.size<1048576 and binary == false
        r = string.gsub(/([^ a-zA-Z0-9_.-]+)/) do |m|
      '%' + m.unpack('H2' * m.size).join('%').upcase
    end.tr(' ', '+')
    return r
  end
    def urldec
    string = self+""
    r=string
    o=""
    while r != o
      o=r
          r = string.gsub(/%([a-fA-F0-9][a-fA-F0-9])/) do |m|
      s="\0"
      s[0]=m[1..2].to_i(16)
      s
    end.tr('+', ' ')
string=r
    end
    return    r
  end
  def delspecial
    string = self+""
    from=["ą","ć","ę","ł","ń","ó","ś","ź","ż","Ą","Ć","Ę","Ń","Ó","Ł","Ś","Ź","Ż","-"]
    to=["a","c","e","l","n","o","s","z","z","A","C","E","L","N","O","S","Z","Z","_"]
    for i in 0..to.size-1
      string.gsub!(from[i],to[i])
      end
    r = string.gsub(/([^ a-zA-Z0-9_.-]+)/) do |m|
      ''
    end.tr(' ', '_')
    return r
  end
  def bigletter
    return true if self[0]>64 and self[0]<91
    return true if self=="Ą" or self=="Ć" or self=="Ę" or self=="Ł" or self == "Ń" or self=="Ó" or self=="Ś" or self=="Ź" or self=="Ż"
    return false
    end
end
#Copyright (C) 2014-2016 Dawid Pieper