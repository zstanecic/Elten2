#ifndef ELTEN_ENGINE_VERSION
#include <emain.h>
#endif
#include <espeech.h>
#ifdef __linux__
void eos(size_t msgid, size_t cid, SPDNotificationType t)
{
sem_post(&sem);
}
#endif
VALUE EltenEngineSpeech_say(VALUE self, VALUE saytext, VALUE outputtype, VALUE alter) {
				 		#ifdef _WIN32
	if(outputtype==0)
sayString(StringValuePtr(saytext),alter);
	else
	sapiSayString(StringValuePtr(saytext),alter);
#endif
#ifdef __linux__
spd_sayf(sp, SPD_IMPORTANT, StringValuePtr(saytext));
if(alter == true)
{
sem_wait(&sem);
}
#endif
}

VALUE EltenEngineSpeech_stop(VALUE self, VALUE outputtype) {
	#ifdef _WIN32
	if(outputtype==0)
	stopSpeech();
	else
	sapiStopSpeech();
	#endif
#ifdef __linux__
spd_stop(sp);
#endif
}

VALUE EltenEngineSpeech_isspeaking(VALUE self) {
#ifdef _WIN32
return sapiIsSpeaking();
#endif
}

VALUE EltenEngineSpeech_getnumvoices(VALUE self) {
#ifdef _WIN32
return sapiGetNumVoices();
#endif
}

VALUE EltenEngineSpeech_getvoice(VALUE self) {
#ifdef _WIN32
return sapiGetVoice();
#endif
#ifdef __linux__
return rb_str_new_cstr(spd_get_output_module(sp));
#endif
}

VALUE EltenEngineSpeech_setvoice(VALUE self, VALUE voiceid) {
#ifdef _WIN32
return sapiSetVoice(voiceid);
#endif
}

VALUE EltenEngineSpeech_getrate(VALUE self) {
#ifdef _WIN32
return sapiGetRate();
#endif
#ifdef __linux__
return INT2NUM(spd_get_voice_rate(sp));
#endif
}

VALUE EltenEngineSpeech_setrate(VALUE self, VALUE vol) {
#ifdef _WIN32
return sapiSetRate(vol);
#endif
#ifdef __linux__
return spd_set_voice_rate(sp, NUM2INT(vol));
#endif
}
VALUE EltenEngineSpeech_getvolume(VALUE self) {
#ifdef _WIN32
return sapiGetVolume();
#endif
#ifdef __linux__
return INT2NUM(spd_get_volume(sp));
#endif
}

VALUE EltenEngineSpeech_setvolume(VALUE self, VALUE vol) {
#ifdef _WIN32
return sapiSetVolume(vol);
#endif
#ifdef __linux__
return spd_set_volume(sp, NUM2INT(vol));
#endif
}

VALUE EltenEngineSpeech_getvoicename(VALUE self, VALUE id) {
#ifdef _WIN32
return rb_str2_new(sapiGetVoiceName(id));
#endif
}

VALUE EltenEngineSpeech_getoutputmethod(VALUE self) {
#ifdef _WIN32
return GetCurrentScreenReader();
#endif
}

VALUE EltenEngineSpeech_ispaused(VALUE self) {
#ifdef _WIN32
return sapiIsPaused();
#endif
}

VALUE EltenEngineSpeech_setpaused(VALUE self, VALUE s) {
#ifdef _WIN32
return sapiSetPaused(s);
#endif
}

void EAPISpeech_INIT(VALUE mMod) {
	VALUE mEltenEngineSpeech = rb_define_module_under(mMod, "Speech");
rb_define_module_function(mEltenEngineSpeech, "say", EltenEngineSpeech_say, 3);
rb_define_module_function(mEltenEngineSpeech, "stop",EltenEngineSpeech_stop,1);
rb_define_module_function(mEltenEngineSpeech, "isspeaking",EltenEngineSpeech_isspeaking,0);
rb_define_module_function(mEltenEngineSpeech, "getnumvoices",EltenEngineSpeech_getnumvoices,0);
rb_define_module_function(mEltenEngineSpeech, "getvoice",EltenEngineSpeech_getvoice,0);
rb_define_module_function(mEltenEngineSpeech, "setvoice",EltenEngineSpeech_setvoice,1);
rb_define_module_function(mEltenEngineSpeech, "getrate",EltenEngineSpeech_getrate,0);
rb_define_module_function(mEltenEngineSpeech, "setrate",EltenEngineSpeech_setrate,1);
rb_define_module_function(mEltenEngineSpeech, "getvolume",EltenEngineSpeech_getvolume,0);
rb_define_module_function(mEltenEngineSpeech, "setvolume",EltenEngineSpeech_setvolume,1);
rb_define_module_function(mEltenEngineSpeech, "getvoicename",EltenEngineSpeech_getvoicename,1);
rb_define_module_function(mEltenEngineSpeech, "getoutputmethod",EltenEngineSpeech_getoutputmethod,0);
rb_define_module_function(mEltenEngineSpeech, "ispaused",EltenEngineSpeech_ispaused,0);
rb_define_module_function(mEltenEngineSpeech, "setpaused",EltenEngineSpeech_setpaused,1);
#ifdef __linux__
sp = spd_open("Elten", "Main", NULL, SPD_MODE_THREADED);
sem_init(&sem, 0, 0);
sp->callback_end = sp->callback_cancel = eos;
spd_set_notification_on(sp, SPD_END);
spd_set_notification_on(sp, SPD_CANCEL);
#endif
}


