#Elten Code
#Copyright (C) 2014-2016 Dawid Pieper
#All rights reserved.


#Open Public License is used to licensing this app!

class Scene_Advanced
  def main
    @field=[]
    @field[0] = Edit.new("Czas odświerzania stanu klawiszy (ms) (Uwaga! Nie zaleca się zmiany tej wartości!)","",$advanced_keyms.to_s,true)
    @field[1] = CheckBox.new("Przetwarzaj diakretyki heksagonalnie (zaawansowane)")
    @field[2] = Edit.new("Czas odświerzania sesji (s) (Uwaga! Nie zaleca się zmiany tej wartości!)","",$advanced_refreshtime.to_s,true)
            @field[3]=CheckBox.new("Wykorzystuj streaming audio, jeśli obsługiwany")
        @field[4]=CheckBox.new("Synchronizuj czas z serwerem")
    @field[5] = Button.new("Zapisz")
    @field[6] = Button.new("Anuluj")
    @form = Form.new(@field)
@form.fields[0].settext(readini($configdata + "\\advanced.ini","Advanced","KeyUpdateTime","75").to_s)
@form.fields[1].checked = readini($configdata + "\\advanced.ini","Advanced","HexSpecial","1").to_i
@form.fields[2].settext(readini($configdata + "\\advanced.ini","Advanced","RefreshTime","5").to_s)
@form.fields[3].checked = readini($configdata + "\\advanced.ini","Advanced","SoundStreaming","1").to_i
@form.fields[4].checked = readini($configdata + "\\advanced.ini","Advanced","SyncTime","1").to_i
      @field[0].focus  
loop do
      loop_update
      @form.update
      if ((enter or space) and @form.index == 5) or ($key[0x12] == true and enter)
@form.fields[0].finalize
writeini($configdata + "\\advanced.ini","Advanced","KeyUpdateTime",@form.fields[0].text_str)
writeini($configdata + "\\advanced.ini","Advanced","HexSpecial",@form.fields[1].checked.to_s)
writeini($configdata + "\\advanced.ini","Advanced","SoundStreaming",@form.fields[3].checked.to_s)
writeini($configdata + "\\advanced.ini","Advanced","SyncTime",@form.fields[4].checked.to_s)
@form.fields[2].finalize
writeini($configdata + "\\advanced.ini","Advanced","RefreshTime",@form.fields[2].text_str)
$advanced_keyms = @form.fields[0].text_str.to_i
$advanced_hexspecial = @form.fields[1].checked.to_i
$advanced_refreshtime = @form.fields[2].text_str.to_i
$advanced_soundstreaming = @form.fields[3].checked.to_i  
$advanced_synctime = @form.fields[4].checked.to_i  
speech("Zapisano")
speech_wait
if $name != nil and $name != "" and $token != nil and $token != ""
$scene = Scene_Main.new
else
  $scene = Scene_Loading.new
  end
  return
break
        end
      if escape or ((enter or space) and @form.index == 6)
        if $name != nil and $name != "" and $token != nil and $token != ""
$scene = Scene_Main.new
else
  $scene = Scene_Loading.new
  end
            break
          return
        end
      end
  end
  end
#Copyright (C) 2014-2016 Dawid Pieper