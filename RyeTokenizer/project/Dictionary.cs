using System;
using System.Collections;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;
using System.Threading.Tasks;

namespace LollipopUI
{
	public static class Dictionary
	{
		public static ArrayList m_words1 = new ArrayList();
		public static ArrayList m_words2 = new ArrayList();
		public static ArrayList m_words3 = new ArrayList();
		public static ArrayList m_words4 = new ArrayList();

		public static void LoadWordList(string path)
		{
			var _filestream = new System.IO.FileStream(path,
										  System.IO.FileMode.Open,
										  System.IO.FileAccess.Read,
										  System.IO.FileShare.ReadWrite);
			var _file = new System.IO.StreamReader(_filestream, System.Text.Encoding.UTF8, true, 128);

			string _word = null;
			while ((_word = _file.ReadLine()) != null)
			{
				int _countSyllable = CountSyllable(_word);

				switch(_countSyllable)
				{
					case 1:
						m_words1.Add(_word);
						break;
					case 2:
						m_words2.Add(_word);
						break;
					case 3:
						m_words3.Add(_word);
						break;
					case 4:
						m_words4.Add(_word);
						break;
					default:
						m_words4.Add(_word);
						break;
				}
			}

			_file.Dispose();
			_filestream.Dispose();
		}

		public static int CountSyllable(string word)
		{
			return word.Split(' ').Length;
		}

		public static bool IsInDictionary(string word)
		{
			int _countSyllable = CountSyllable(word);

			switch (_countSyllable)
			{
				case 1:
					if (m_words1.Contains(word))
						return true;
					break;
				case 2:
					if (m_words2.Contains(word))
						return true;
					break;
				case 3:
					if (m_words3.Contains(word))
						return true;
					break;
				case 4:
					if (m_words4.Contains(word))
						return true;
					break;
				default:
					if (m_words4.Contains(word))
						return true;
					break;
			}

			return false;
		}
	}

	public class Tokenizer
	{
		public ArrayList Tokenizing(string content)
		{
			content = content.Replace("\n", " ");
			content = content.Replace("\t", " ");
			content = content.Replace("&nbsp;", " ");

			ArrayList _wordsTokenized = new ArrayList();

			string newContent = Regex.Replace(content, @"[^A-Za-z0-9]+", "");

			string[] abcdef = newContent.Split(' ');



			while (content != "")
			{
				for(int i = 4; i >= 1; i--)
				{
					//string _rawWord = Regex.Match(content, @"^(\w+\b.*?){" + i + "}").ToString();
					string _rawWord = string.Join(" ", content.Split().Take(i));

					string _word = null;
					if (i != 1)
						_word = new string(_rawWord.Where(c => char.IsLetterOrDigit(c) || char.IsWhiteSpace(c) || c == '-').ToArray());
					else
					{
						_word = _rawWord;
					}

					_word = _word.ToLower();

					if (Dictionary.IsInDictionary(_word))
					{
						_wordsTokenized.Add(_word);
						content = content.Replace(_rawWord + " ", String.Empty);
						break;
					}
					else if(i == 1)
					{
						content = content.Replace(_rawWord + " ", String.Empty);
					}
				}
			}



			return _wordsTokenized;
		}
	}

	public class Word
	{
		public string m_content;
		public float m_weight;

		public Word(string content, float weight)
		{
			m_content = content;
			m_weight = weight;
		}

		public static string Join(string delimiter, ArrayList listWords)
		{
			string _result = "";

			foreach(Word _word in listWords)
			{
				_result += _word.m_content + '|' + _word.m_weight + Environment.NewLine;
			}

			return _result;
		}
	}

	public class Indexer
	{
		public ArrayList Indexing(string title, string tags, ArrayList words)
		{
			ArrayList _wordsIndexed = new ArrayList();
			Tokenizer _tokenizer = new Tokenizer();

			string[] _wordsInTitle = (_tokenizer.Tokenizing(title).ToArray(typeof(string)) as string[]).Distinct().ToArray();
			foreach (string _word in _wordsInTitle)
			{
				_wordsIndexed.Add(new Word(_word, 1));
			}



			string[] _wordsInTags = tags.Split('|');
			foreach(string _word in _wordsInTags)
			{
				if (!_wordsIndexed.Contains(_word))
					_wordsIndexed.Add(new Word(_word, 1));
			}



			int _wordsCount = words.Count;
			Dictionary<string, int> _distinctWordsCounting = (words.ToArray(typeof(string)) as string[]).GroupBy(x => x)
									  .ToDictionary(g => g.Key,
													g => g.Count());
			
			foreach (KeyValuePair<string, int> _word in _distinctWordsCounting)
			{
				if (!_wordsIndexed.Contains(_word.Key))
				{
					float _termFrequency = (float)_word.Value / _wordsCount;
					_wordsIndexed.Add(new Word(_word.Key, _termFrequency));
				}
			}

			return _wordsIndexed;
		}
	}
}
